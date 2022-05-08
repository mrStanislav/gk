<?php

spl_autoload_register(function ($class_name) {
   include "classes/".$class_name . '.php';
});


class gk {
	
	public $handler_view = null;
	public $filter = null;
	public $list_menu = null;
	
	public $gk_filed = [
		'GK_CADASTRAL_NUMBER' => 'Кадастровый номер',
		'GK_ADRESS' => 'Адрес',
		'GK_ROOM_PLAN_NUMBER' => 'Номер квартиры по плану',
		'GK_ROOM_AREA' => 'Площадь квартиры',
		'GK_ROOM_TEXT_NUMBER' => 'Номер квартиры',
		'GK_ROOM_CNT' => 'Кол-во комнат',
		'GK_OWN_TYPE' => 'Тип собственности',
		'GK_OWNER_NAME' => 'Имя собственника',
		'GK_VOTES_IN_TOTAL_AREA' => 'Кол-во голосов',
		'GK_RESTRICTIONS' => 'Права',
		'GK_FLOOR' => 'Этаж',
		'GK_SECTION' => 'Номер подъезда',
		'GK_KORPUS' => 'Номер копуса'	
	];
	
	public function __construct()
	{
		$this->handler_view = new view();	
		$this->filter = $this->_prepare_filter((object)$_REQUEST);
		$this->list_menu = model::get_list_menu();
	}
	
	public function index()
	{
		
		$section_info = $this->_get_list_section();
		$floor_margin = $this->_calc_margin_floor($section_info);

		$this->handler_view->render('main', [
			'section_info' => $section_info, 
			'floor_margin' => $floor_margin,
			'list_menu'    => $this->list_menu,
			'filter'       => $this->filter
		]);
		
		
	}
	
	/** Prepare list section */
	public function _get_list_section()
	{		
		$masp = [];
		$info_list = model::get_gk_list($this->filter);
		foreach($info_list as $key => $value)
		{
			$masp[$value->GK_SECTION][$value->GK_FLOOR][$value->GK_ROOM_PLAN_NUMBER] = $value;
		}	

		return $masp;		
	}
	
	/** Calc margin for sections */
	public function _calc_margin_floor($arr)
	{
		if(count($arr)>0)
		{
			$masp = [];
			$floor_margin = [];
			foreach($arr as $key => $value)
			{
				$masp[$key] = count($value)+1;
			}
			
			$max_floor =  max($masp) ;
			foreach($masp as $key => $value)
			{
				$floor_margin[$key] = (int)$max_floor - $value;
			}			
		}
		
		return $floor_margin;		
	}
	
	/** Prepare filter  */
	public function _prepare_filter($filter)
	{
		$_filter = ['corps', 'porch', 'corps_rus', 'room_id'];		
		foreach($_filter as $key => $value)
		{	
			if($value != 'corps_rus')
			{
				if(!isset($filter->{$value}))
				{
					
					$filter->{$value} = ($key == 'corps') ? '1k1' : 1;
				}
			}
			else
			{
				$filter->corps_rus = (isset($filter->corps)) ? strtr($filter->corps, ['k'=> 'к']) : '1к1';
			}
		}	
		
		return $filter;		
	}
	
	
	/* Method for jquery ajax (get additional info about room */
	public function get_room_info()
	{
		$room_info = model::room_info($this->filter);
		$this->handler_view->render('room_info', ['room_info' => $room_info, 'remap_filed' => $this->gk_filed], true);
	}
	
}

	$gk = new gk();

	switch ($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		case 'XMLHttpRequest':
				$gk->get_room_info();
			break;
		default:
				$gk->index();
			break;
	}
	
?>