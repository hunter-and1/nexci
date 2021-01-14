<?php 

if (!function_exists('nex_smtp_is_valid')) {
    function nex_smtp_is_valid()
    {
        return ! empty(trim(service('settings')->smtpHost)) && ! empty(trim(service('settings')->smtpPort));
    }
}

if (!function_exists('nex_create_slug')) {
    function nex_create_slug($table, $col,$title)
    {
        helper('text');

        $db = db_connect();
        $count = 0;
        $name = strtolower(url_title(convert_accented_characters($title), '-', TRUE));
        $slug_name = $name;
        while(true) 
        {
            $builder = $db->table($table);
            $builder->where($col, $slug_name);
            $query = $builder->get()->getRow();
            if ($query == false) 
                break;
            $slug_name = $name . '-' . (++$count);
        }
        return $slug_name; 
    }
}

if (!function_exists('nex_format')) {
    function nex_format($n){
        if ( intval( $n ) ) {
            return number_format( $n , 2, '.', ' ');
        } else {
            return '0.00';
        }
    }
}


if (! function_exists('nex_max_file_upload_in_bytes'))
{	
	function nex_max_file_upload_in_bytes()
	{
		// Select maximum upload size
		$max_upload = return_bytes(ini_get('upload_max_filesize'));

		// Select post limit
		$max_post = return_bytes(ini_get('post_max_size'));

		// Select memory limit
		$memory_limit = return_bytes(ini_get('memory_limit'));

		// Return the smallest of them, this defines the real limit
		return min($max_upload, $max_post, $memory_limit);
	}
}

if (!function_exists('nex_to')) {
    function nex_to($str,...$data)
    {
        return route_to('App\Controllers\\'.$str,...$data);
    }
}

if (!function_exists('nex_object_attr')) {
    function nex_object_attr($data)
    {
        return htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('nex_now')) {
    function nex_now()
    {
        return date('Y-m-d H:i:s');
    }
}

if (! function_exists('nex_page_active'))
{
	function nex_page_active($routing,$type_return = true)
	{
		$return = "";
		foreach ($routing as $route) {
			if(preg_grep('/^'.$route.'/', [uri_string()]))
				$return = 'active';
		}
		if(is_bool($type_return) && $type_return === true)
			return $return;
		else if(is_bool($type_return) && $type_return === false)	
			return !empty($return);
		else 
			return !empty($return)?$type_return:'';
	
	}
}

if (! function_exists('nex_have_access'))
{
	function nex_have_access($permissions)
	{
		if(!empty($permissions))
		{
			if(is_array($permissions))
			{
				foreach ($permissions as $permission) 
				{
					if(!has_permission($permission))
					{
                        die("u dont have access");
					}
				}
			}
			else if (is_string($permissions)) 
			{
				if(!has_permission($permissions))
				{
					die("u dont have access");
				}
			}
		}

	}
}

if (!function_exists('nex_image_to_base64')) {
    
    function nex_image_to_base64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

if (!function_exists('nex_size_paper')) {
    function nex_size_paper($size = "a4")
    {
        if(strtolower($size) == "a1")
        {
            return [
                'size' => "A1",
                'height' => "841mm",
                'width' => "594mm",
            ];
        }
        elseif(strtolower($size) == "a2")
        {
            return [
                'size' => "A2",
                'height' => "594mm",
                'width' => "420mm",
            ];
        }
        elseif(strtolower($size) == "a3")
        {
            return [
                'size' => "A3",
                'height' => "420mm",
                'width' => "297mm",
            ];
        }
        elseif(strtolower($size) == "a4")
        {
            return [
                'size' => "A4",
                'height' => "297mm",
                'width' => "210mm",
            ];
        }
        elseif(strtolower($size) == "a5")
        {
            return [
                'size' => "A5",
                'height' => "210mm",
                'width' => "148mm",
            ];
        }
        elseif(strtolower($size) == "a6")
        {
            return [
                'size' => "A6",
                'height' => "148mm",
                'width' => "105mm",
            ];
        }
        elseif(strtolower($size) == "a7")
        {
            return [
                'size' => "A7",
                'height' => "105mm",
                'width' => "74mm",
            ];
        }
        else{
            return [
                'size' => "A4",
                'height' => "297mm",
                'width' => "210mm",
            ];
        }
    }
}

/*

if (! function_exists('get_protected'))
{
	function get_protected($object,array $property)
	{
		$r = [];
		$reflection = new ReflectionClass($object);
		foreach ($property as $prop) {
			$p = $reflection->getProperty($prop);
			$p->setAccessible(true);
			$r[$prop] = $p->getValue($object);
		}
		return $r;
	}
}
 */