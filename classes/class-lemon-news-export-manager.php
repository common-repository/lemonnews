<?php


/**
* Export Manager. Handles exporting files
* @author Vitor Rigoni <vitor@lemonjuicewebapps.com>
* @version 1.0
* @package LemonNews
*/
class LemonNewsExportManager
{
	
	/**
	 * Class constructor sets base header parameters
	 */
	function __construct()
	{
		header("Cache-Control: max-age=0");
		header('Pragma: no-cache');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
	}

	/**
	 * Exports txt file
	 * @return plain/text txt file
	 */
	public function export_txt()
	{
        header('Content-Type: plain/text');
        header('Content-Disposition: attachment; filename=lemon-news-full-list.txt');

        $model = new LemonNewsModel();
		$str = "";

		$all = $model->select_emails();

		foreach ($all as $item)
				$str .= trim($item->email) . "\n ";

        echo $str;
        exit;
	}

	/**
	 * Exports as Microsoft Excel File
	 * @return xls Excel file
	 */
	public function export_xls()
	{
		// header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"lemon-news-full-list.xls\"");

		$model = new LemonNewsModel();

		$all = $model->select_emails();

		$str = "ID\t" . __("Date Created") . "\t" . __("Date Modified") . "\t" . "E-mail\r";
		
		foreach ($all as $item) {
			$str .= "$item->id\t$item->date_created\t";
			if (!empty($item->date_modified)) $str .= $item->date_modified . "\t";
			else $str .= "--\t";
			$str .= "$item->email\r";
		}

		echo $str;
		exit;
	}

	/**
	 * Exports as CSV file
	 * @return csv CSV File
	 */
	public function export_csv()
	{
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=\"lemon-news-full-list.csv\"");

		$model = new LemonNewsModel();

		$all = $model->select_emails();
		$str = "";

		foreach ($all as $item)
			$str .= "$item->email,";

		echo $str;
		exit;
	}

	/**
	 * Exports a XML file. Not really sure what good it'll do, but...
	 * @return xml xml file
	 */
	public function export_xml()
	{
		header("Content-Type: text/xml");
		header("Content-Disposition: attachment; filename\"lemon-news-full-list.xml\"");

		$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		$str .= "<author>LemonNews WordPress Plugin</author>\n";
		$str .= "<description>".__("Full list of registered e-mails")."</description>\n";

		$model = new LemonNewsModel();

		$all = $model->select_emails();

		foreach ($all as $item) {
			$str .= "<register>\n";
			$str .= "\t<id>$item->id</id>\n";
			$str .= "\t<datecreated>$item->date_created</datecreated>\n";
			$str .= "\t<datemodified>$item->date_modified</datemodified>\n";
			$str .= "\t<email>$item->email</email>\n";
			$str .= "</register>\n";
		}

		echo $str;
		exit;
	}
}






















