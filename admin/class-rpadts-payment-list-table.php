<?php
/**
 * Plugin Name: RPADTS Settings
 *
 * @package RPADTS_Settings
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class Rpadts_Payment_List_Table
 * Handles displaying the list of Stripe payments in the WordPress admin.
 *
 * @package StripePaymentManagement
 */
class Rpadts_Payment_List_Table extends WP_List_Table {

	/**
	 * Rpadts_Payment_List_Table constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'subscriber', // Singular name of the listed records.
				'plural'   => 'subscribers', // Plural name of the listed records.
				'ajax'     => false,        // Does this table support ajax?
			)
		);
	}

	/**
	 * Default column method.
	 *
	 * @param array  $item The data item.
	 * @param string $column_name The column name.
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'name':
				return esc_html( $item['first_name'] . ' ' . $item['last_name'] );
			case 'payment_id':
				return esc_html( $item['payment_id'] );
			case 'phone_number':
				return esc_html( $item['phone_number'] );
			case 'address':
				return esc_html( $item['address'] . ', ' . $item['city'] . ' - ' . $item['zipcode'] . ', ' . $item['state'] . ', ' . $item['country'] );
			case 'amount':
				return esc_html( $item['amount'] );
			case 'donation_type':
				return esc_html( $item['donation_type'] );
			case 'created_at':
				return esc_html( $item['created_at'] );
			default:
				return print_r( $item, true ); // Show the whole array for troubleshooting purposes.
		}
	}

	/**
	 * Title column method.
	 *
	 * @param array $item The data item.
	 * @return string
	 */
	public function column_title( $item ) {
		$actions = array(
			'edit'   => sprintf(
				'<a href="%s">Edit</a>',
				esc_url(
					add_query_arg(
						array(
							'page' => isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '',
							'action' => 'edit',
							'subscriber' => intval( $item['id'] ),
						)
					)
				)
			),
			'delete' => sprintf(
				'<a href="%s">Delete</a>',
				esc_url(
					add_query_arg(
						array(
							'page' => isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '',
							'action' => 'delete',
							'subscriber' => intval( $item['id'] ),
						)
					)
				)
			),
		);

		return sprintf(
			'%1$s <span style="color:silver">(id:%2$s)</span> %3$s',
			esc_html( $item['name'] ),
			esc_html( $item['id'] ),
			$this->row_actions( $actions )
		);
	}

	/**
	 * Checkbox column method.
	 *
	 * @param array $item The data item.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			esc_attr( $this->_args['singular'] ),
			intval( $item['id'] )
		);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'              => '<input type="checkbox" />',
			'name'            => 'Name',
			'payment_id'      => 'Payment ID',
			'phone_number'    => 'Mobile Number',
			'address'         => 'Address',
			'amount'          => 'Amount',
			'donation_type'   => 'Payment Type',
			'created_at'      => 'Created at',
		);
	}

	/**
	 * Get sortable columns.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'name'         => array( 'first_name', false ),
			'created_at'   => array( 'created_at', false ),
		);
	}

	/**
	 * Get bulk actions.
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => 'Delete',
		);
	}

	/**
	 * Process bulk action.
	 */
	public function process_bulk_action() {
		global $wpdb;
		$table_transaction = $wpdb->prefix . 'stripe_transaction_table';

		if ( 'delete' === $this->current_action() ) {
			$ids = isset( $_REQUEST['subscriber'] ) ? array_map( 'intval', $_REQUEST['subscriber'] ) : array();

			if ( ! empty( $ids ) ) {
				$placeholders = implode( ',', array_fill( 0, count( $ids ), '%d' ) );

				$sql = "DELETE FROM $table_transaction WHERE id IN ($placeholders)";
				$wpdb->query( $wpdb->prepare( $sql, ...$ids ) );
			}
		}
	}

	/**
	 * Prepare items.
	 */
	public function prepare_items() {
		global $wpdb;
		$table_transaction = $wpdb->prefix . 'stripe_transaction_table';

		$per_page = 20; // Records per page.

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->process_bulk_action();

		$search_name = isset( $_REQUEST['search_name'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['search_name'] ) ) : '';
		$search_payment_id = isset( $_REQUEST['search_payment_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['search_payment_id'] ) ) : '';

		$search_query = '';
		$query_params = array();

		if ( $search_name ) {
			$name_parts = explode( ' ', $search_name, 2 );
			$fname = isset( $name_parts[0] ) ? sanitize_text_field( $name_parts[0] ) : '';
			$lname = isset( $name_parts[1] ) ? sanitize_text_field( $name_parts[1] ) : '';

			if ( $fname ) {
				$search_query .= ' AND first_name = %s';
				$query_params[] = $fname;
			}
			if ( $lname ) {
				$search_query .= ' AND last_name = %s';
				$query_params[] = $lname;
			}
		}
		if ( $search_payment_id ) {
			$search_query .= ' AND payment_id = %s';
			$query_params[] = $search_payment_id;
		}

		$orderby = isset( $_REQUEST['orderby'] ) && array_key_exists( sanitize_key( $_REQUEST['orderby'] ), $this->get_sortable_columns() )
			? sanitize_key( $_REQUEST['orderby'] )
			: 'created_at';
		$order = isset( $_REQUEST['order'] ) && in_array( sanitize_key( $_REQUEST['order'] ), array( 'asc', 'desc' ), true )
			? sanitize_key( $_REQUEST['order'] )
			: 'desc';

		// Define $offset for pagination.
		$current_page = isset( $_REQUEST['paged'] ) ? intval( $_REQUEST['paged'] ) : 1;
		$offset = ( $current_page - 1 ) * $per_page;

		$this->items = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT * FROM %1s
				WHERE payment_status = 'succeeded' %2s
				ORDER BY %3s %4s
				LIMIT %5d OFFSET %6d
				",
				$table_transaction,
				$search_query,
				$orderby,
				$order,
				$per_page,
				$offset
			),
			ARRAY_A
		);

		$count_query_params = array_merge( $query_params );

		$total_items = $wpdb->get_var(
			$wpdb->prepare(
				"
					SELECT COUNT(id)
					FROM %1s
					WHERE payment_status = 'succeeded' %2s
				",
				$table_transaction,
				$search_query,
				...$count_query_params
			)
		);

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $total_items / $per_page ),
			)
		);
	}
}

/**
 * Display the Stripe payments list table.
 */
function rpadts_payments() {
	$rpadts_list_table = new Rpadts_Payment_List_Table();

	$rpadts_list_table->prepare_items();
	?>
	<div class="wrap">
		<div id="icon-users" class="icon32"><br/></div>
		<h2><?php esc_html_e( 'Stripe Payments', 'rpadts' ); ?></h2>
		<?php $rpadts_list_table->views(); ?>
		<form id="payments-filter" method="get">
		<?php
		  $page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		?>
			<input type="hidden" name="page" value="<?php echo esc_attr( $page ); ?>" />
		<?php
			$rpadts_list_table->search_box( 'search', 'search_id' );
			$rpadts_list_table->display();
		?>
		</form>
	</div>
	<?php
}

/**
 * Register admin menu.
 */
function rpadts_admin_menu() {
	add_menu_page( 'Stripe Payments', 'Stripe Payments', 'manage_options', 'rpadts-payments', 'rpadts_payments' );
}

add_action( 'admin_menu', 'rpadts_admin_menu' );
