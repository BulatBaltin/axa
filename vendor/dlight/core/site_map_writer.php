<?php
class SiteMapWriter{
    
public $file;
public $cur_file;
public $counter;
public $counter_all=0;
public $max_recs_in_one_file;
public $eos;

function __construct()
{
   $this->file = fopen(dirname(dirname(dirname(__FILE__)))."/sitemap.xml","w");
  if(!$this->file)
    {
      echo("Ошибка открытия файла sitemap.xml");
    }
    
    $this->cur_file="";
    $this->counter=0;
    $this->max_recs_in_one_file=6000;
    $this->eos="\r\n"; 
}



function BeginWrite()
{

    fputs( $this->file, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".$this->eos);
    fputs($this->file, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"".$this->eos);
    fputs($this->file, "xmlns:image=\"http://www.sitemaps.org/schemas/sitemap-image/1.1\"".$this->eos);
    
    fputs($this->file, "xmlns:video=\"http://www.sitemaps.org/schemas/sitemap-video/1.1\">".$this->eos);

}

function EndWrite()
{

    fputs( $this->file, "</urlset>".$this->eos);
    fclose($this->file);

}



function Write($str,$freq="daily",$prio="0.8")
  {
    if($this->counter<$this->max_recs_in_one_file)
    {
        
     fputs( $this->file, "<url>".$this->eos);   
     fputs( $this->file, "<loc>".$str."</loc>".$this->eos);
     fputs( $this->file, "<changefreq>".$freq."</changefreq>".$this->eos);
     fputs( $this->file, "<priority>".$prio."</priority>".$this->eos);
     fputs( $this->file, "</url>".$this->eos);
     $this->counter++;
     $this->counter_all++;
    }
    else
    {           
    
        
          
       if($this->cur_file=="")
       {$this->cur_file=1;}
       else
       {$this->cur_file++;}
        $this->EndWrite();
       //fclose($this->file);
       $this->file = fopen("sitemap{$this->cur_file}.xml","w");
       $this->BeginWrite();
       if(!$this->file)
        {
          echo("Ошибка открытия файла sitemap{$this->cur_file}.xml");
        }
        
        $this->counter=0;  

        echo "move to ".$this->cur_file;
        
    }
  
  }

}
?>