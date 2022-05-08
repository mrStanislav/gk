<?
class model {
	
	public static function get_gk_list($filter)
	{
		
		$sql = "SELECT
					T1.GK_KORPUS,
					T1.GK_SECTION,
					T1.GK_FLOOR,
					T1.GK_ROOM_PLAN_NUMBER
				FROM
					gk_plan T1
				WHERE
					T1.GK_KORPUS = :GK_KORPUS
				    AND T1.GK_SECTION = :GK_SECTION
				GROUP BY
					trim(T1.GK_KORPUS),
					trim(T1.GK_SECTION),
					trim(T1.GK_FLOOR),
					trim(T1.GK_ROOM_PLAN_NUMBER)
				ORDER BY				    
					T1.GK_SECTION ASC,
					T1.GK_FLOOR DESC,
					T1.GK_ROOM_PLAN_NUMBER ASC";
		$stmt = database::getInstance()->getConnection()->prepare($sql);
		$stmt->execute(array('GK_SECTION' => $filter->porch, 'GK_KORPUS' => $filter->corps_rus)); 
		
		return $stmt->fetchAll(PDO::FETCH_CLASS);

	}
	
	public static function get_list_menu()
	{
		$masp = [];
		$sql = "SELECT
					T1.GK_KORPUS,
					T1.GK_SECTION
				FROM
					gk_plan T1
				GROUP BY
					T1.GK_KORPUS,
					T1.GK_SECTION";
		$stmt = database::getInstance()->getConnection()->prepare($sql);
		$stmt->execute(); 
		$res = $stmt->fetchAll(PDO::FETCH_CLASS);
		
		if(count($res)>0)
		{
			foreach($res as $key => $value)
			{
				$value->GK_KORPUS_ENG = strtr($value->GK_KORPUS, ['к'=> 'k']);
				$masp[$value->GK_KORPUS][] = $value;
			}
		}
		
		
		return $masp;
	}		


	public static function room_info($filter)
	{
		
		$sql = "SELECT
					*
				FROM
					gk_plan T1
				WHERE
					1 = 1
				AND T1.GK_ROOM_PLAN_NUMBER = :GK_ROOM_PLAN_NUMBER
				AND T1.GK_KORPUS  = :GK_KORPUS
				AND T1.GK_SECTION = :GK_SECTION";
				
		$stmt = database::getInstance()->getConnection()->prepare($sql);
		$stmt->execute(array('GK_SECTION' => $filter->porch, 'GK_KORPUS' => $filter->corps_rus, 'GK_ROOM_PLAN_NUMBER'=> $filter->room_id)); 
		
		return $stmt->fetchAll(PDO::FETCH_CLASS);

	}		



}
