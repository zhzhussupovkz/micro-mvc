<?php

//FtpHelper - класс для работы с ftp
class FtpHelper extends Helper {

	//текущее соединение
	private $conn;

	//установка соединения с FTP-сервером
	/*
	$ftp = new FtpHelper();
	if ($ftp->connect($server)) {
		//...
	}
	*/
	public function connect($server) {
		try {
			$conn = ftp_connect($server['host'], $server['port']);
			if (!$conn) {
				throw new Exception("Ошибка установки соединения с ".$server['host']);
			}
			$this->conn = $conn;
			return true;
		}
		catch (Exception $e) {
			echo 'Не удалось установить соединение с ftp сервером: '.$e->getMessage();
			return false;
		}
	}

	//закрытие соединения
	/*
	$ftp->close();
	*/
	public function close() {
		ftp_close($this->conn);
	}

	//вход на FTP-сервер
	/*
	$username = 'user';
	$password = 'password';
	if($ftp->login($username, $password)) {
		//...
	}
	*/
	public function login($username, $password) {
		try {
			$login = ftp_login($this->conn, $username, $password);
			if (!$login) {
				throw new Exception("Ошибка доступа для пользователя ".$username);
			}
			return true;
		}
		catch (Exception $e) {
			echo 'Нет доступа к FTP-серверу: '.$e->getMessage();
			return false;
		}
	}

	//загружает удаленный файл
	public function download($remoteFile, $localFile, $mode = 'FTP_BINARY') {
		try {
			$get = ftp_get($this->conn, $localFile, $remoteFile, $mode);
			if (!$get) {
				throw new Exception("Не удалось закачать удаленный файл");
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//загружает файл на FTP-сервер
	public function upload($remoteFile, $localFile, $mode = 'FTP_BINARY') {
		try {
			$put = ftp_put($this->conn, $remoteFile, $localFile, $mode);
			if (!$put) {
				throw new Exception("Не удалось загрузить файл на FTP-сервер");
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//получение размера файла
	public function getSize($filename) {
		try {
			$size = ftp_size($this->conn, $filename);
			if ($size == -1) {
				throw new Exception('Не удалось получить размер файла');
			}
			return $size;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	//устанавливает права доступа к файлу
	public function chmod($filename, $mode) {
		try {
			$chmod = ftp_chmod($this->conn, $mode, $filename);
			if (!$chmod) {
				throw new Exception("Не удалось установить права на файл ".$filename);
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//удаление файла
	public function delele($filename) {
		try {
			$del = ftp_delete($this->conn, $filename);
			if (!$del) {
				throw new Exception("Не удалось удалить файл: ".$filename);
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/*
	скачивает файл с FTP-сервера в 
	асинхронном режиме и сохраняет его в локальный файл
	*/
	public function downloadAsync($localFile, $remoteFile, $mode = 'FTP_BINARY') {
		try {
			if (ftp_nb_get($this->conn, $localFile, $remoteFile, $mode) != 'FTP_FINISHED') {
				throw new Exception("При скачивании файла произошла ошибка");
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/*
	загружает файл на FTP-сервер в асинхронном режиме
	*/
	public function uploadAsync($localFile, $remoteFile, $mode = 'FTP_BINARY') {
		try {
			if (ftp_nb_put($this->conn, $remoteFile, $localFile, $mode) != 'FTP_FINISHED') {
				throw new Exception("При загрузки файла на FTP-сервер произошла ошибка");
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//создает директорию на FTP-сервере
	public function createDir($directory) {
		try {
			$dir = ftp_mkdir($this->conn, $directory);
			if(!$dir) {
				throw new Exception("Не удалось создать папку ".$directory);
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return false;
	}

	//удаляет директорию на FTP-сервере
	public function removeDir($directory) {
		try {
			$dir = ftp_rmdir($this->conn, $directory);
			if(!$dir) {
				throw new Exception("Не удалось удалить папку ".$directory);
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return false;
	}

	//смена директории на заданную
	public function chdir($directory) {
		try {
			$dir = ftp_chdir($this->conn, $directory);
			if (!$dir) {
				throw new Exception("Не удалось сменить директорию на ".$directory);
			}
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//текущая директория
	public function currentDir() {
		return ftp_pwd($this->conn);
	}

	//получение списка файлов из указанной папки
	public function list($directory) {
		return ftp_nlist($this->conn, $directory);
	}
}