<?php namespace Aurer\Autoschema;

use Log;
use File;
use Config;
use Response;
use DB;

class AutoBackup
{
	// public	$encode;		// Base64 enocode filenames of the backups ?
	// private $_host;			// Myslq host location ?
	// private $_user;			// Myslq username ?
	// private $_password;		// Mysql password ?
	// private $_database;		// Database connection info from the config ?
	// private $_path;			// Path to the database backups ?
	// private $_date;			// Date used to create filenames ?
	// private $_extension;	// File extension for backups ?
	// private $_mysql_path;	// Location of mysql application ?
	
	/**
	 * List all backups
	 *
	 * @return array
	 * @author Phil Maurer
	 **/
	public static function backups($table=false)
	{
		$backup_files = static::find_backups($table);
		sort($backup_files);
		$backups = array();
		foreach ($backup_files as $backup) {
			$info = static::get_backup_info($backup);
			$backups[$info['table']][] = $info;
		}
		return $backups;
	}

	/**
	 * Return an array of information from a backup files filename
	 *
	 * @return array
	 * @author Phil Maurer
	 **/
	protected static function get_backup_info($filename)
	{

		preg_match_all('/([\D]+)_([0-9]{4})_([0-9]{1,2})_([0-9]{1,2})_([0-9]{2})([0-9]{2})([0-9]{2})/', $filename, $matches);
		//               \_____/ \________/ \__________/ \__________/ \________/\________/\________/
		//              tablename   year       month         day         hour     minute    second

		list($full_match, $table, $year, $month, $day, $hours, $minutes, $seconds) = $matches;
		
		//return mktime($hours[0], $minutes[0], $seconds[0], $month[0], $day[0], $year[0]);	
		$timestamp = mktime($hours[0], $minutes[0], $seconds[0], $month[0], $day[0], $year[0]);
		$timestamp = date('Y-m-d H:i:s', $timestamp);
		$filesize = filesize(static::backup_path() . DS . $filename);
		
		return array(
			'table' => $table[0],
			'filesize' => $filesize,
			'timestamp' => $timestamp,
		);
	}

	/**
	 * Backup a table
	 *
	 * @param  string $table
	 * @return boolean
	 * @author Phil Maurer
	 **/
	public static function backup($table)
	{
		$database = Config::get('database.connections');
		
		// Create a timestamp filename
		$filename = static::backup_path() . '/' . $table. '_' . date('Y_n_j_His') . EXT;
		
		// Dump the table as JSON
		$dump = DB::table($table)->get();
		$content = Response::json($dump)->content;

		// Write the file
		File::put($filename, $content);
		
		// Return the size of the new file
		return filesize($filename);
	}

	/**
	 * Restore a table from a backup
	 *
	 * @param  string $table
	 * @param  int $version
	 * @return mixed
	 * @author Phil Maurer
	 **/
	public static function restore($table, $version=false)
	{
		$version = $version === false ? 0 : $version;
		$backups = static::find_backups($table);
		$backup_json = json_decode( file_get_contents( static::backup_path() . DS . $backups[$version]) );
		foreach ($backup_json as $key => $value) {
			 
		}
	}

	/**
	 * Return an array of backup files for the specified table
	 * or all tables if no table is specified.
	 *
	 * @param  string $table
	 * @return array
	 * @author Phil Maurer
	 **/
	protected static function find_backups($table=false)
	{
		$backup_dir = static::backup_path();
		$backups = array();

		if( !$table ){
			$backups = glob( $backup_dir . '/*.php');
		} else {
			$backups = glob( $backup_dir . '/' . $table . '_*.php');
		}
				
		return str_replace($backup_dir . '/', '', $backups);
	}

	/**
	 * Return the path to the backup directory
	 *
	 * @return string
	 * @author Phil Maurer
	 **/
	protected static function backup_path()
	{
		$backup_dir = path('storage') . Config::get('autoschema.backup_dir');
		// Make the backup directory
		if( !is_dir($backup_dir) ){
			File::mkdir($backup_dir);
		}
		return $backup_dir;
	}
	
	/*
		Restores a table using a backup, either a specified version or the last one if not specified
		(true/false)
	*/
	public function restore_table($table, $version=false)
	{
		// Backup files matching the table name
		$backups = $this->find_backups($table);
		if( count($backups) < 1 )
			return count($backups);
		
		$versions = $this->find_backups($table);
		
		if(!$version){
			$version_number = array_search($file, $versions);
			$file = end($versions);
		}
		else{
			$version_number = $version;
			foreach($backups as $b){
				if( preg_match('/[\\w-]+\.[0-9-]+\.'. $version .'\.'. $this->_extension .'/', $b) )
					$file = $b;
			}
		}
		if(!$file)
			return false;
		
		list($version_name, $version_date, $version_number) = explode('.', strrchr($file, '/'));		
		
		
		if( file_exists($file) ){
			$command = $this->_mysql_path."mysql --verbose --user=".$this->_user." --password=".$this->_password." ".$this->_database." < $file";
			$output = shell_exec($command);
			if( trim($output) != ''){
				log_write("Succesfully Restored '$table' from backup version '$version_number' dated '$version_date'.");
				return true;
			} else {
				log_write("MYSQL Restore failed: There was a problem executing the shell command.", 'ERROR');
				log_write("MYSQL Restore command: '$command'", 'ERROR');
				return false;
			}
		}
		else{
			log_write("MYSQL Restore failed: Backup file '$file' could not be found.", 'ERROR');
			return false;
		}
	}
	
	/*
		Finds all the backup versions of a table returns an array: version=>backup-date
		(array/0)	
	
	public function find_backup_versions($table)
	{
		$backups = $this->find_backups($table);
		
		if( count($backups) < 1 OR $backups===false)
			return 0;
		
		foreach($backups as $f){
		
			$full_filename = str_ireplace("$this->_path/", '', $f);
			list($name, $date, $version) = explode('.', $full_filename);
			$versions[$version] = $date;
		}
		return $versions;
	}
	*/	
}