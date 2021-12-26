<?php
class api_cache{
    public $cache_status=false;
    public $contents;
    public $req;    
    public $refresh=3600;
    function check(){
        $file='script_cache/'.$this->req.'.txt';
        if(file_exists($file)){
            //Check the last modified
            $last_modified=filemtime($file);
            $time_now=time();
            $diff=$time_now-$last_modified;
            if($diff<=$this->refresh){
                //The cache has not yet expired let read it                                                   
                $this->cache_status=true;
                return true;
            }else{
                //The cache has expired
                $this->cache_status=false;
                return false;
            }
        }else{
            $this->cache_status=false;
            return false;
        }
    }
    function read(){
        $file='script_cache/'.$this->req.'.txt';
        $this->contents=file_get_contents($file);                        
        echo $this->contents;
    }
    function write(){
        $file='script_cache/'.$this->req.'.txt';
        fopen($file,'w+');
        file_put_contents($file,$this->contents);
    }
}