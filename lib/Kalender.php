<?php

class Kalender extends DateTime
{
	protected static $bulan = array(
		'Januari' 	=> '01',
		'Februari' 	=> '02',
		'Maret' 		=> '03',
		'April' 		=> '04',
		'Mei' 		=> '05',
		'Juni' 		=> '06',
		'Juli' 		=> '07',
		'Agustus' 	=> '08',
		'September' 	=> '09',
		'Oktober' 	=> '10',
		'November' 	=> '11',
		'Desember' 	=> '12',
	);

	protected static $keterangan = array(
		'ini',
		'besok',
		'kemarin',
		'lalu'
	);
	
	const bulan_per_tahun = 12;
	const minggu_per_tahun = 52;
	const hari_per_minggu = 7;
	const jam_per_hari = 24;
	const menit_per_jam = 60;
	const detik_per_menit = 60;

	protected static $ketWaktu = array(
		self::detik_per_menit => 'detik',
		self::menit_per_jam => 'menit',
		self::jam_per_hari => 'jam',
		self::hari_per_minggu => 'hari',
		self::minggu_per_tahun => 'minggu',
		self::bulan_per_tahun => 'bulan',
	);

	public static function tanggal($tanggal = null)
	{
		return ($tanggal === null) ? date('j') : substr($tanggal, 8, 2);
	}

	public static function bulan($bulan = null)
	{
		$b = ($bulan === null) ? date('m') : substr($bulan, 5, 2);
		
		foreach (static::$bulan as $key => $value) {
			if($value === $b){
				return $key;
			}
		}
	}

	public static function tahun($tahun = null)
	{
		return ($tahun === null) ? date('Y') : substr($tahun, 0, 4);
	}

	public static function waktu($waktu = null)
	{
		return ($waktu === null) ? date('H:i:s') : substr($waktu, 11, 8);
	}

	public static function tglNormal($datetime = null)
	{
		return static::tanggal($datetime).' '.static::bulan($datetime).' '.static::tahun($datetime);
	}

	public static function tglWaktu($datetime = null)
	{
		return static::tglNormal($datetime).' - '.static::waktu($datetime);
	}

	public static function formatPosting()
	{
		return static::$ketWaktu;
	}
}