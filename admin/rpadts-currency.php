<?php
/**
 * Plugin Name: RPADTS Settings
 *
 * @package RPADTS_Settings
 */

/**
 * Returns an array of currencies with their details.
 *
 * @return array An associative array of currencies where the key is the currency code (lowercase)
 *               and the value is an array containing 'code', 'name', and 'symbol'.
 */
function rpadts_currencies() {
	return array(
		'aed' => array(
			'code'   => 'AED',
			'name'   => 'United Arab Emirates Dirham',
			'symbol' => 'DH',
		),
		'afn' => array(
			'code'   => 'AFN',
			'name'   => 'Afghan Afghani',
			'symbol' => '؋',
		),
		'all' => array(
			'code'   => 'ALL',
			'name'   => 'Albanian Lek',
			'symbol' => 'L',
		),
		'amd' => array(
			'code'   => 'AMD',
			'name'   => 'Armenian Dram',
			'symbol' => '֏',
		),
		'ang' => array(
			'code'   => 'ANG',
			'name'   => 'Netherlands Antillean Gulden',
			'symbol' => 'ƒ',
		),
		'aoa' => array(
			'code'   => 'AOA',
			'name'   => 'Angolan Kwanza',
			'symbol' => 'Kz',
		),
		'ars' => array(
			'code'   => 'ARS',
			'name'   => 'Argentine Peso',
			'symbol' => '$',
		),
		'aud' => array(
			'code'   => 'AUD',
			'name'   => 'Australian Dollar',
			'symbol' => '$',
		),
		'awg' => array(
			'code'   => 'AWG',
			'name'   => 'Aruban Florin',
			'symbol' => 'ƒ',
		),
		'azn' => array(
			'code'   => 'AZN',
			'name'   => 'Azerbaijani Manat',
			'symbol' => 'm.',
		),
		'bam' => array(
			'code'   => 'BAM',
			'name'   => 'Bosnia & Herzegovina Convertible Mark',
			'symbol' => 'KM',
		),
		'bbd' => array(
			'code'   => 'BBD',
			'name'   => 'Barbadian Dollar',
			'symbol' => 'Bds$',
		),
		'bdt' => array(
			'code'   => 'BDT',
			'name'   => 'Bangladeshi Taka',
			'symbol' => '৳',
		),
		'bgn' => array(
			'code'   => 'BGN',
			'name'   => 'Bulgarian Lev',
			'symbol' => 'лв',
		),
		'bif' => array(
			'code'   => 'BIF',
			'name'   => 'Burundian Franc',
			'symbol' => 'FBu',
		),
		'bmd' => array(
			'code'   => 'BMD',
			'name'   => 'Bermudian Dollar',
			'symbol' => 'BD$',
		),
		'bnd' => array(
			'code'   => 'BND',
			'name'   => 'Brunei Dollar',
			'symbol' => 'B$',
		),
		'bob' => array(
			'code'   => 'BOB',
			'name'   => 'Bolivian Boliviano',
			'symbol' => 'Bs.',
		),
		'brl' => array(
			'code'   => 'BRL',
			'name'   => 'Brazilian Real',
			'symbol' => 'R$',
		),
		'bsd' => array(
			'code'   => 'BSD',
			'name'   => 'Bahamian Dollar',
			'symbol' => 'B$',
		),
		'bwp' => array(
			'code'   => 'BWP',
			'name'   => 'Botswana Pula',
			'symbol' => 'P',
		),
		'bzd' => array(
			'code'   => 'BZD',
			'name'   => 'Belize Dollar',
			'symbol' => 'BZ$',
		),
		'cad' => array(
			'code'   => 'CAD',
			'name'   => 'Canadian Dollar',
			'symbol' => '$',
		),
		'cdf' => array(
			'code'   => 'CDF',
			'name'   => 'Congolese Franc',
			'symbol' => 'CF',
		),
		'chf' => array(
			'code'   => 'CHF',
			'name'   => 'Swiss Franc',
			'symbol' => 'Fr',
		),
		'clp' => array(
			'code'   => 'CLP',
			'name'   => 'Chilean Peso',
			'symbol' => 'CLP$',
		),
		'cny' => array(
			'code'   => 'CNY',
			'name'   => 'Chinese Renminbi Yuan',
			'symbol' => '¥',
		),
		'cop' => array(
			'code'   => 'COP',
			'name'   => 'Colombian Peso',
			'symbol' => 'COL$',
		),
		'crc' => array(
			'code'   => 'CRC',
			'name'   => 'Costa Rican Colón',
			'symbol' => '₡',
		),
		'cve' => array(
			'code'   => 'CVE',
			'name'   => 'Cape Verdean Escudo',
			'symbol' => 'Esc',
		),
		'czk' => array(
			'code'   => 'CZK',
			'name'   => 'Czech Koruna',
			'symbol' => 'Kč',
		),
		'djf' => array(
			'code'   => 'DJF',
			'name'   => 'Djiboutian Franc',
			'symbol' => 'Fr',
		),
		'dkk' => array(
			'code'   => 'DKK',
			'name'   => 'Danish Krone',
			'symbol' => 'kr',
		),
		'dop' => array(
			'code'   => 'DOP',
			'name'   => 'Dominican Peso',
			'symbol' => 'RD$',
		),
		'dzd' => array(
			'code'   => 'DZD',
			'name'   => 'Algerian Dinar',
			'symbol' => 'DA',
		),
		'egp' => array(
			'code'   => 'EGP',
			'name'   => 'Egyptian Pound',
			'symbol' => 'L.E.',
		),
		'etb' => array(
			'code'   => 'ETB',
			'name'   => 'Ethiopian Birr',
			'symbol' => 'Br',
		),
		'eur' => array(
			'code'   => 'EUR',
			'name'   => 'Euro',
			'symbol' => '€',
		),
		'fjd' => array(
			'code'   => 'FJD',
			'name'   => 'Fijian Dollar',
			'symbol' => 'FJ$',
		),
		'fkp' => array(
			'code'   => 'FKP',
			'name'   => 'Falkland Islands Pound',
			'symbol' => 'FK£',
		),
		'gbp' => array(
			'code'   => 'GBP',
			'name'   => 'British Pound',
			'symbol' => '£',
		),
		'gel' => array(
			'code'   => 'GEL',
			'name'   => 'Georgian Lari',
			'symbol' => 'ლ',
		),
		'gip' => array(
			'code'   => 'GIP',
			'name'   => 'Gibraltar Pound',
			'symbol' => '£',
		),
		'gmd' => array(
			'code'   => 'GMD',
			'name'   => 'Gambian Dalasi',
			'symbol' => 'D',
		),
		'gnf' => array(
			'code'   => 'GNF',
			'name'   => 'Guinean Franc',
			'symbol' => 'FG',
		),
		'gtq' => array(
			'code'   => 'GTQ',
			'name'   => 'Guatemalan Quetzal',
			'symbol' => 'Q',
		),
		'gyd' => array(
			'code'   => 'GYD',
			'name'   => 'Guyanese Dollar',
			'symbol' => 'G$',
		),
		'hkd' => array(
			'code'   => 'HKD',
			'name'   => 'Hong Kong Dollar',
			'symbol' => 'HK$',
		),
		'hnl' => array(
			'code'   => 'HNL',
			'name'   => 'Honduran Lempira',
			'symbol' => 'L',
		),
		'hrk' => array(
			'code'   => 'HRK',
			'name'   => 'Croatian Kuna',
			'symbol' => 'kn',
		),
		'htg' => array(
			'code'   => 'HTG',
			'name'   => 'Haitian Gourde',
			'symbol' => 'G',
		),
		'huf' => array(
			'code'   => 'HUF',
			'name'   => 'Hungarian Forint',
			'symbol' => 'Ft',
		),
		'idr' => array(
			'code'   => 'IDR',
			'name'   => 'Indonesian Rupiah',
			'symbol' => 'Rp',
		),
		'ils' => array(
			'code'   => 'ILS',
			'name'   => 'Israeli New Sheqel',
			'symbol' => '₪',
		),
		'inr' => array(
			'code'   => 'INR',
			'name'   => 'Indian Rupee',
			'symbol' => '₹',
		),
		'isk' => array(
			'code'   => 'ISK',
			'name'   => 'Icelandic Króna',
			'symbol' => 'ikr',
		),
		'jmd' => array(
			'code'   => 'JMD',
			'name'   => 'Jamaican Dollar',
			'symbol' => 'J$',
		),
		'jpy' => array(
			'code'   => 'JPY',
			'name'   => 'Japanese Yen',
			'symbol' => '¥',
		),
		'kes' => array(
			'code'   => 'KES',
			'name'   => 'Kenyan Shilling',
			'symbol' => 'Ksh',
		),
		'kgs' => array(
			'code'   => 'KGS',
			'name'   => 'Kyrgyzstani Som',
			'symbol' => 'COM',
		),
		'khr' => array(
			'code'   => 'KHR',
			'name'   => 'Cambodian Riel',
			'symbol' => '៛',
		),
		'kmf' => array(
			'code'   => 'KMF',
			'name'   => 'Comorian Franc',
			'symbol' => 'CF',
		),
		'krw' => array(
			'code'   => 'KRW',
			'name'   => 'South Korean Won',
			'symbol' => '₩',
		),
		'kyd' => array(
			'code'   => 'KYD',
			'name'   => 'Cayman Islands Dollar',
			'symbol' => 'CI$',
		),
		'kzt' => array(
			'code'   => 'KZT',
			'name'   => 'Kazakhstani Tenge',
			'symbol' => '₸',
		),
		'lak' => array(
			'code'   => 'LAK',
			'name'   => 'Lao Kip',
			'symbol' => '₭',
		),
		'lbp' => array(
			'code'   => 'LBP',
			'name'   => 'Lebanese Pound',
			'symbol' => 'LL',
		),
		'lkr' => array(
			'code'   => 'LKR',
			'name'   => 'Sri Lankan Rupee',
			'symbol' => 'SLRs',
		),
		'lrd' => array(
			'code'   => 'LRD',
			'name'   => 'Liberian Dollar',
			'symbol' => 'L$',
		),
		'lsl' => array(
			'code'   => 'LSL',
			'name'   => 'Lesotho Loti',
			'symbol' => 'M',
		),
		'mad' => array(
			'code'   => 'MAD',
			'name'   => 'Moroccan Dirham',
			'symbol' => 'DH',
		),
		'mdl' => array(
			'code'   => 'MDL',
			'name'   => 'Moldovan Leu',
			'symbol' => 'MDL',
		),
		'mga' => array(
			'code'   => 'MGA',
			'name'   => 'Malagasy Ariary',
			'symbol' => 'Ar',
		),
		'mkd' => array(
			'code'   => 'MKD',
			'name'   => 'Macedonian Denar',
			'symbol' => 'ден',
		),
		'mnt' => array(
			'code'   => 'MNT',
			'name'   => 'Mongolian Tögrög',
			'symbol' => '₮',
		),
		'mop' => array(
			'code'   => 'MOP',
			'name'   => 'Macanese Pataca',
			'symbol' => 'MOP$',
		),
		'mro' => array(
			'code'   => 'MRO',
			'name'   => 'Mauritanian Ouguiya',
			'symbol' => 'UM',
		),
		'mur' => array(
			'code'   => 'MUR',
			'name'   => 'Mauritian Rupee',
			'symbol' => 'Rs',
		),
		'mvr' => array(
			'code'   => 'MVR',
			'name'   => 'Maldivian Rufiyaa',
			'symbol' => 'Rf.',
		),
		'mwk' => array(
			'code'   => 'MWK',
			'name'   => 'Malawian Kwacha',
			'symbol' => 'MK',
		),
		'mxn' => array(
			'code'   => 'MXN',
			'name'   => 'Mexican Peso',
			'symbol' => '$',
		),
		'myr' => array(
			'code'   => 'MYR',
			'name'   => 'Malaysian Ringgit',
			'symbol' => 'RM',
		),
		'mzn' => array(
			'code'   => 'MZN',
			'name'   => 'Mozambican Metical',
			'symbol' => 'MT',
		),
		'nad' => array(
			'code'   => 'NAD',
			'name'   => 'Namibian Dollar',
			'symbol' => 'N$',
		),
		'ngn' => array(
			'code'   => 'NGN',
			'name'   => 'Nigerian Naira',
			'symbol' => '₦',
		),
		'nio' => array(
			'code'   => 'NIO',
			'name'   => 'Nicaraguan Córdoba',
			'symbol' => 'C$',
		),
		'nok' => array(
			'code'   => 'NOK',
			'name'   => 'Norwegian Krone',
			'symbol' => 'kr',
		),
		'npr' => array(
			'code'   => 'NPR',
			'name'   => 'Nepalese Rupee',
			'symbol' => 'NRs',
		),
		'nzd' => array(
			'code'   => 'NZD',
			'name'   => 'New Zealand Dollar',
			'symbol' => 'NZ$',
		),
		'pab' => array(
			'code'   => 'PAB',
			'name'   => 'Panamanian Balboa',
			'symbol' => 'B/.',
		),
		'pen' => array(
			'code'   => 'PEN',
			'name'   => 'Peruvian Nuevo Sol',
			'symbol' => 'S/.',
		),
		'pgk' => array(
			'code'   => 'PGK',
			'name'   => 'Papua New Guinean Kina',
			'symbol' => 'K',
		),
		'php' => array(
			'code'   => 'PHP',
			'name'   => 'Philippine Peso',
			'symbol' => '₱',
		),
		'pkr' => array(
			'code'   => 'PKR',
			'name'   => 'Pakistani Rupee',
			'symbol' => 'PKR',
		),
		'pln' => array(
			'code'   => 'PLN',
			'name'   => 'Polish Złoty',
			'symbol' => 'zł',
		),
		'pyg' => array(
			'code'   => 'PYG',
			'name'   => 'Paraguayan Guaraní',
			'symbol' => '₲',
		),
		'qar' => array(
			'code'   => 'QAR',
			'name'   => 'Qatari Riyal',
			'symbol' => 'QR',
		),
		'ron' => array(
			'code'   => 'RON',
			'name'   => 'Romanian Leu',
			'symbol' => 'RON',
		),
		'rsd' => array(
			'code'   => 'RSD',
			'name'   => 'Serbian Dinar',
			'symbol' => 'дин',
		),
		'rub' => array(
			'code'   => 'RUB',
			'name'   => 'Russian Ruble',
			'symbol' => 'руб',
		),
		'rwf' => array(
			'code'   => 'RWF',
			'name'   => 'Rwandan Franc',
			'symbol' => 'FRw',
		),
		'sar' => array(
			'code'   => 'SAR',
			'name'   => 'Saudi Riyal',
			'symbol' => 'SR',
		),
		'sbd' => array(
			'code'   => 'SBD',
			'name'   => 'Solomon Islands Dollar',
			'symbol' => 'SI$',
		),
		'scr' => array(
			'code'   => 'SCR',
			'name'   => 'Seychellois Rupee',
			'symbol' => 'SRe',
		),
		'sek' => array(
			'code'   => 'SEK',
			'name'   => 'Swedish Krona',
			'symbol' => 'kr',
		),
		'sgd' => array(
			'code'   => 'SGD',
			'name'   => 'Singapore Dollar',
			'symbol' => 'S$',
		),
		'shp' => array(
			'code'   => 'SHP',
			'name'   => 'Saint Helenian Pound',
			'symbol' => '£',
		),
		'sll' => array(
			'code'   => 'SLL',
			'name'   => 'Sierra Leonean Leone',
			'symbol' => 'Le',
		),
		'sos' => array(
			'code'   => 'SOS',
			'name'   => 'Somali Shilling',
			'symbol' => 'Sh.So.',
		),
		'std' => array(
			'code'   => 'STD',
			'name'   => 'São Tomé and Príncipe Dobra',
			'symbol' => 'Db',
		),
		'srd' => array(
			'code'   => 'SRD',
			'name'   => 'Surinamese Dollar',
			'symbol' => 'SRD',
		),
		'svc' => array(
			'code'   => 'SVC',
			'name'   => 'Salvadoran Colón',
			'symbol' => '₡',
		),
		'szl' => array(
			'code'   => 'SZL',
			'name'   => 'Swazi Lilangeni',
			'symbol' => 'E',
		),
		'thb' => array(
			'code'   => 'THB',
			'name'   => 'Thai Baht',
			'symbol' => '฿',
		),
		'tjs' => array(
			'code'   => 'TJS',
			'name'   => 'Tajikistani Somoni',
			'symbol' => 'TJS',
		),
		'top' => array(
			'code'   => 'TOP',
			'name'   => 'Tongan Paʻanga',
			'symbol' => '$',
		),
		'try' => array(
			'code'   => 'TRY',
			'name'   => 'Turkish Lira',
			'symbol' => '₺',
		),
		'ttd' => array(
			'code'   => 'TTD',
			'name'   => 'Trinidad and Tobago Dollar',
			'symbol' => 'TT$',
		),
		'twd' => array(
			'code'   => 'TWD',
			'name'   => 'New Taiwan Dollar',
			'symbol' => 'NT$',
		),
		'tzs' => array(
			'code'   => 'TZS',
			'name'   => 'Tanzanian Shilling',
			'symbol' => 'TSh',
		),
		'uah' => array(
			'code'   => 'UAH',
			'name'   => 'Ukrainian Hryvnia',
			'symbol' => '₴',
		),
		'ugx' => array(
			'code'   => 'UGX',
			'name'   => 'Ugandan Shilling',
			'symbol' => 'USh',
		),
		'usd' => array(
			'code'   => 'USD',
			'name'   => 'United States Dollar',
			'symbol' => '$',
		),
		'uyu' => array(
			'code'   => 'UYU',
			'name'   => 'Uruguayan Peso',
			'symbol' => '$U',
		),
		'uzs' => array(
			'code'   => 'UZS',
			'name'   => 'Uzbekistani Som',
			'symbol' => 'UZS',
		),
		'vnd' => array(
			'code'   => 'VND',
			'name'   => 'Vietnamese Đồng',
			'symbol' => '₫',
		),
		'vuv' => array(
			'code'   => 'VUV',
			'name'   => 'Vanuatu Vatu',
			'symbol' => 'VT',
		),
		'wst' => array(
			'code'   => 'WST',
			'name'   => 'Samoan Tala',
			'symbol' => 'WS$',
		),
		'xaf' => array(
			'code'   => 'XAF',
			'name'   => 'Central African Cfa Franc',
			'symbol' => 'FCFA',
		),
		'xcd' => array(
			'code'   => 'XCD',
			'name'   => 'East Caribbean Dollar',
			'symbol' => 'EC$',
		),
		'xof' => array(
			'code'   => 'XOF',
			'name'   => 'West African Cfa Franc',
			'symbol' => 'CFA',
		),
		'xpf' => array(
			'code'   => 'XPF',
			'name'   => 'Cfp Franc',
			'symbol' => 'F',
		),
		'yer' => array(
			'code'   => 'YER',
			'name'   => 'Yemeni Rial',
			'symbol' => '﷼',
		),
		'zar' => array(
			'code'   => 'ZAR',
			'name'   => 'South African Rand',
			'symbol' => 'R',
		),
		'zmw' => array(
			'code'   => 'ZMW',
			'name'   => 'Zambian Kwacha',
			'symbol' => 'ZK',
		),
	);
}
