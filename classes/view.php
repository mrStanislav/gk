<?
class view {
	
    public function render_template() 
    {              
        return require '/home/admin/web/parkrc.ru/public_html/gk/views/template.php';                      
    }
	
    public function render ($view, array $params = [], $screen = false)
    { 	    
        $file_name = '/home/admin/web/parkrc.ru/public_html/gk/views/'.$view.'.php';
        extract($params);
        ob_start();
		if(!$screen)
		{
			$this->render_template();  
		}
        require $file_name;
        $mp = ob_get_clean();
        ob_end_clean();
        echo  $mp;   
    }	
}
?>