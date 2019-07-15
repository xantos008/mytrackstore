<?php
namespace common\components;

use Yii;

class MP3_Crop { 

    /** 
    * mp3/mpeg file name 
    * @var boolean 
    */ 
    var $file = false;       

    /** 
    * version of bitrate 
    * @var integer 
    */         
    var $bitrate = 0; 
    var $layer; 
     
    /** 
    * Bytes in file  
    * @var integer 
    */ 

    var $filesize = -1; 
    /** 
    * Byte at which the first mpeg header was found 
    * @var integer 
    */                             
     
    var $frameoffset = -1; 
    /** 
    * length of mp3 format hh:ss 
    * @var string 
    */ 

    /** 
    * length of mp3 in seconds 
    * @var string 
    */                             
    var $length = false; 


    /* 
     * creates a new id3 object 
     * and loads a tag from a file. 
     * 
     */ 
    function MP3_Crop() 
    { 
    } 

    /** 
    * reads the given file and parse it 
    * 
    * @param    string  $file the name of the file to parse 
    * @return   mixed   PEAR_Error on error 
    * @access   public 
    */ 
    function read($file) 
    { 
        $this->file = $file; 

        return $this->_readframe(); 
    } 


    /** 
     * update the id3v1 tags on the file. 
     * Note: If/when ID3v2 is implemented this method will probably get another 
     *       parameters. 
     *      
     * @param boolean $v1   if true update/create an id3v1 tag on the file. (defaults to true) 
     *  
     * @access public 
     */ 
    function write($cropFile, $length = 20) 
    { 
        $size = ($length * $this->bitrate * 1000) / 8; 
         
        $f = fopen($this->file, 'rb'); 
        if (!$f) 
        { 
            return false; 
        } 

        $content = fread($f, $size); 
        fclose($f); 

        $f = fopen($cropFile, 'wb'); 
        if (!$f) 
        { 
            return false; 
        } 
         
        fwrite($f, $content); 
        fclose($f); 

        return true; 
    } 


    /** 
    * reads a frame from the file 
    * 
    * @return mixed PEAR_Error when fails 
    * @access private 
    */ 
    function _readframe() 
    { 
        $file = $this->file; 

        if (! ($f = fopen($file, 'rb')) ) 
        { 
            return false; 
        } 

        $this->filesize = filesize($file); 

        do 
        { 
            while (fread($f,1) != Chr(255)) 
            {  
                // Find the first frame 
                if (feof($f)) 
                { 
                    return false; 
                } 
            } 
            fseek($f, ftell($f) - 1); // back up one byte 

            $frameoffset = ftell($f); 

            $r = fread($f, 4); 
            // Binary to Hex to a binary sting. ugly but best I can think of. 
            $bits = unpack('H*bits', $r); 
            $bits =  base_convert($bits['bits'],16,2); 
         
        } while (!$bits[8] and !$bits[9] and !$bits[10]); // 1st 8 bits true from the while 

        $this->frameoffset = $frameoffset; 

        fclose($f); 

        if ($bits[11] == 0) { 
            $bitrates = array( 
                '1' => array(0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0), 
                '2' => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0), 
                '3' => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0), 
                     ); 
        } else if ($bits[12] == 0) { 
            $bitrates = array( 
                '1' => array(0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0), 
                '2' => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0), 
                '3' => array(0,  8, 16, 24, 32, 40, 48,  56,  64,  80,  96, 112, 128, 144, 160, 0), 
                     ); 
        } else { 
            $bitrates = array( 
                '1' => array(0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448, 0), 
                '2' => array(0, 32, 48, 56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 384, 0), 
                '3' => array(0, 32, 40, 48,  56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 0), 
                     ); 
        } 

        $layer = array( 
            array(0,3), 
            array(2,1), 
                  ); 
        $this->layer = $layer[$bits[13]][$bits[14]]; 

        $bitrate = 0; 
        if ($bits[16] == 1) $bitrate += 8; 
        if ($bits[17] == 1) $bitrate += 4; 
        if ($bits[18] == 1) $bitrate += 2; 
        if ($bits[19] == 1) $bitrate += 1; 
        $this->bitrate = $bitrates[$this->layer][$bitrate]; 

        if ($this->bitrate == 0) 
        { 
            $this->length = -1; 
            return false; 
        } 

        $s = ((8 * filesize($this->file)) / 1000) / $this->bitrate; 
        $this->length = (int)$s; 

        return true; 
    } 
}; 
?>