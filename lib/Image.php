<?php
class Image {

	protected $name;
	protected $filetype;
	protected $filename;
	protected $filetmp;
	public $imageName;
	public $imageFile = array();
	protected $typedata = array("jpeg", "jpg", "png");
	protected $type = array("image/jpeg", "image/jpg", "image/png");

	public function save($path = null, $size = null) 
	{
		$this->name = array_keys($_FILES)[0];
		$this->filename = (empty($_FILES[$this->name]['name'])) ? array_filter($_FILES[$this->name]['name']) : $_FILES[$this->name]['name'];
		$this->filetype = (empty($_FILES[$this->name]['type'])) ? array_filter($_FILES[$this->name]['type']) : $_FILES[$this->name]['type'];
		$this->filetmp = (empty($_FILES[$this->name]['tmp_name'])) ? array_filter($_FILES[$this->name]['tmp_name']) : $_FILES[$this->name]['tmp_name'];

		if(!empty($this->filename) && !empty($this->filetype)) {
			$path = ($path == null) ? dirname(__FILE__).'/../assets/images/' : $path;
			$size = ($size == null) ? 2000000 : $size;

			if($this->checkExtension() && $this->checkType() && $size) {
				if(is_array($this->extension())){
					foreach ($this->extension() as $ex) {
						$this->imageFile[] = uniqid().".".$ex;
						$this->imageName = $this->imageName();
					}
					foreach ($this->imageFile as $k => $i) {
						$this->createDirectory($path);
						move_uploaded_file($this->filetmp[$k], $path.$i);
					}
				}else {
					$this->imageFile = uniqid().".".$this->extension();
					$this->imageName = $this->imageName();
					$this->createDirectory($path);
					move_uploaded_file($this->filetmp, $path.$this->imageFile);
				}
			} else {
				throw new Exception("File tidak didukung.");
			}
		}else {
			return false;
		}
	}

	public function remove($imgFile)
	{
		if(is_array($imgFile)){
			foreach ($imgFile as $value) {
				if(file_exists(dirname(__FILE__).'/../assets/images/'.$value)) {
					unlink(dirname(__FILE__).'/../assets/images/'.$value);
				}
			}
		}else {
			unlink(dirname(__FILE__).'/../assets/images/'.$imgFile);
		}
	}

	protected function imageName()
	{
		if(is_array($this->filename)) {
			foreach ($this->filename as $n) {
				$nm = explode('.', $n);
				$name[] = $nm[0];
			}

			return $name;
		} else {
			return explode('.', $this->filename)[0];
		}
	}

	protected function extension()
	{
		if(is_array($this->filename)) {
			foreach ($this->filename as $name) {
				$ext = explode('.', $name);
				$extension[] = $ext[1];
			}

			return $extension;
		} else {
			return explode('.', $this->filename)[1];
		}
	}

	protected function type()
	{
		if(is_array($this->filetype)) {
			foreach ($this->filetype as $t) {
				$type[] = $t;
			}

			return $type;
		} else {
			return $this->filetype;
		}
	}

	protected function checkExtension()
	{
		if(is_array($this->extension())){
			foreach ($this->extension() as $t) {
				return (in_array($t, $this->typedata)) ? true : false;
			}
		}else {
			return in_array($this->extension(),$this->typedata);
		}
	}

	protected function checkType()
	{
		if(is_array($this->type())){
			foreach ($this->type() as $t) {
				return (in_array($t, $this->type)) ? true : false;
			}
		}else {
			return in_array($this->type(),$this->type);
		}
	}

	protected function createDirectory($path)
	{	
		if (!is_dir($path)) mkdir($path, 0755, true);
	}
}