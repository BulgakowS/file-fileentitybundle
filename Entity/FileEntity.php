<?php

namespace Brainx2\File\FileEntityBundle\Entity;

/**
 * Description of FileEntity
 *
 * @author Joker | Brainx2
 */
abstract class FileEntity {
    
    /**
     * files array
     * @var array 
     */
    protected $files = array();
    
    /**
     * function setFiles
     * 
     * set file to files array
     * 
     * @param string $field
     */
    public function setFiles($field)
    {
        $this->files[$field] = $this->{$field};
    }
    
    /**
     * function getFiles
     * 
     * get files array
     * 
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }
    
    /**
     * function upload
     * 
     * upload/update all files from files array
     */
    public function upload()
    {
        foreach($this->files as $field=>$file) {
            $fileName = time() . '_' . md5($this->{$field}->getClientOriginalName()) . '.' . $this->{$field}->getClientOriginalExtension();
            
            $this->{$field}->move(
                $this->getUploadRootDir(),
                $fileName
            );
            
            @unlink($this->getUploadRootDir() . DIRECTORY_SEPARATOR . $file);
            
            $this->{$field} = $fileName;
        }
    }
    
    /**
     * function remove
     * 
     * remove all files from files array
     */
    public function remove()
    {
        foreach($this->files as $file) {

            @unlink($this->getUploadRootDir() . DIRECTORY_SEPARATOR . $file);

        }   
    }
    
    /**
     * function getAbsolutePath
     * 
     * get absolute file path
     * 
     * @param string $field
     * @return string
     */
    public function getAbsolutePath($field)
    {
        return null === $this->{$field}
            ? null
            : $this->getUploadRootDir().'/'.$this->{$field};
    }

    /**
     * function getWebPath
     * 
     * get web path to file
     * 
     * @param string $field
     * @return string
     */
    public function getWebPath($field)
    {
        return null === $this->{$field}
            ? null
            : $this->getUploadDir().'/'.$this->{$field};
    }

    /**
     * function getUploadRootDir
     * 
     * full path to files in web directory
     * 
     * @return string
     */
    protected function getUploadRootDir()
    {
        return getcwd() . $this->getUploadDir();
    }
    
    /**
     * function getUploadDir
     * 
     * path to files in web directory
     * 
     * @return string
     */
    protected function getUploadDir()
    {
        return '/uploads/files';
    }  
}
