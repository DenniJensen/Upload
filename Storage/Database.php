<?php
namespace Upload\Storage;

class Database extends \Upload\Storage\Base
{
    protected $_databaseHandler;
    protected $_table;
    protected $_information;

    public function __construct(\Slim\Extras\Database\Mysql $pDatabaseHandler, $pTable, $pInformation = array ())
    {
        $this -> _databaseHandler = $pDatabaseHandler;
        $this -> _table = $pTable;
        $this -> _information = $pInformation;
    }
    
    public function upload(\Upload\File $file, $newName = null)
    {
        if (is_string($newName)) {
            $fileName = strpos($newName, '.') ? $newName : $newName.'.'.$file->getExtension();

        } else {
            $fileName = $file->getNameWithExtension ();
        }
        
        $db = $this -> _databaseHandler;
        $data = file_get_contents ($file->getPathname ());
        return $db -> insert ($this -> _table, 
          array_merge (
            array 
            (
              'Name' => $fileName,
              'Extension' => $file->getExtension(),
              'Mime' => $file->getMimetype(),
              'Size' => $file->getSize(),
              'Md5' => $file->getMd5(),
              'Daten' => $data,
            ), 
            $this -> _information
          )
        );
    }
}
