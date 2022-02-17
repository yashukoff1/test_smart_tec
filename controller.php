<?php 

/**
 * 
 */
class Parcer
{

	private $config_by_phone = [];

	function __construct()
	{
		$this->config_by_phone = $this->get_data_by_phone();
	}

	public function index()
	{
		if (!empty($_FILES['csv_file'])) {
			$this->parce_data($_FILES['csv_file']['tmp_name']);
		}else{
			$this->render('form');
		}
	}

	private function render($file, $params = array(), $return = false)
	{
		ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require_once './view/'.$file.'.php';
        $render = ob_get_clean();
        echo $render;
	}

	private function parce_data($file)
	{
		$csv = array();
		$lines = file($file, FILE_IGNORE_NEW_LINES);
		$data = [];

		foreach ($lines as $key => $line)
		{

			$row_array = str_getcsv($line);

			if (!array_key_exists($row_array[0], $data)) {
				$data[$row_array[0]] = [
					'same_calls' => 0,
					'total_same_duration' => 0,
					'number_of_calls' => 0,
					'total_all_duration' => 0,
				];
			}

			$data[$row_array[0]]['number_of_calls'] += 1;
			$data[$row_array[0]]['total_all_duration'] += $row_array[2];

			$geo_by_phone = $this->filter_by_phone($row_array[3]);
			$geo_by_ip = $this->filter_by_ip($row_array[4]);

			if ($geo_by_phone == $geo_by_ip) {
				$data[$row_array[0]]['same_calls'] += 1;
				$data[$row_array[0]]['total_same_duration'] += $row_array[2];
			}

		}

		$this->render('table', compact('data'));
	}

	private function get_data_by_phone()
	{
		$country_info = array();
		$max_key_len = 0;
		$lines = file('./countryInfo.csv', FILE_IGNORE_NEW_LINES);
		unset($lines[0]);

		foreach ($lines as $key => $line)
		{
			$row_array = str_getcsv($line);
			$dials = explode(',', $row_array[10]);
			foreach($dials as $dial){
				$dial = trim($dial);
				if (empty($dial)) {
					continue;
				}
				$config[$dial] = $row_array[22];
				$key_len = strlen($dial);
				if($max_key_len < $key_len){
					$max_key_len = $key_len;
				}
			}
		}

		return ['config' => $config, 'max_key_len' => $max_key_len];
	}

	private function filter_by_ip($ip)
	{
		$get = array(
			'access_key'  => 'e8e8843cd0279f896223f56e50190a37'
		);
		 
		$ch = curl_init('http://api.ipstack.com/' . $ip . '?' . http_build_query($get));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		 
		$data = json_decode($response);

		if (isset($data->success) && !$data->success) {
			echo 'Code: ' . $data->error->code . '<br>';
			echo 'Info: ' . $data->error->info;
			die;
		}

		return $data->continent_code;
	}

	private function filter_by_phone($phone)
	{
		$continent_config = $this->config_by_phone;

		for ($i=$continent_config['max_key_len']; $i > 0 ; $i--) { 
			$country_code = substr($phone, 0, $i);
			if(array_key_exists($country_code, $continent_config['config'])){
				return $continent_config['config'][$country_code];
			}
		}

	}

}

?>