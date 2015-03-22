<?php
namespace Upload\Storage;

class Callback extends \Upload\Storage\Base
{
  protected $_callback;

  public function __construct($pCallback)
  {
    if(is_callable ($pCallback))
      $this->_callback = $pCallback;
    else
      throw new \InvalidArgumentException('No valid callback given');
  }
    
  public function upload(\Upload\File $file, $newName = null)
  {
    if (is_string($newName)) {
      $fileName = strpos($newName, '.') ? $newName : $newName.'.'.$file->getExtension();
    } else {
      $fileName = $file->getNameWithExtension();
    }
    call_user_func($this->_callback, file_get_contents($file->getPathname()), $fileName);
  }
}
