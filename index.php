<?php
/**
 * mbSitemap
 * 
 * Simple to use plugin to create a sitemap in both HTML and XML.
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		index.php
 * @date		26/12/2009
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

Plugin::setInfos(array(
    'id'          => 'mbsitemap',
    'title'       => 'mbSitemap', 
    'description' => 'Simple to use plugin to create a sitemap in both HTML and XML', 
    'version'     => '1.1.0', 
    'author' 	  => 'Mike Barlow',
    'website'     => 'http://www.mikebarlow.co.uk',
	'update_url'  => 'http://www.mikebarlow.co.uk/mbplugins_version.xml')
);
Observer::observe('page_add_after_save', 'sitemap_generate');
Observer::observe('page_edit_after_save', 'sitemap_generate');
Observer::observe('page_delete', 'sitemap_generate');

// observers for mbblog
// uncomment if you are using mbblog.
/*
Observer::observe('mbblog_after_add', 'sitemap_generate');
Observer::observe('mbblog_after_edit', 'sitemap_generate');
Observer::observe('mbblog_after_del', 'sitemap_generate');
*/

function sitemap_generate($page='', $type='xml')
{
	if($type != 'xml')
	{
		$output = "<div class=\"sitemap\">";
	} else
	{
		$output = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	}
	
	// get all the pages
	$pages = get_pages(0);
	$output .= build_sitemap($pages, $type);
	
// uncomment if you are using mbblog
/* 	$output .= build_mbblog_sitemap($type); */
	
	if($type != 'xml')
	{
		$output .= "</div>";
	} else
	{
		$output .= "</urlset>";
	}
	
	if($type != 'xml')
	{
		echo $output;
	} else
	{
		$fo = @fopen(CMS_ROOT."/sitemap.xml", 'w');
		if(!is_bool($fo))
		{
			$fw = @fwrite($fo, $output);
			$fc = @fclose($fo);
		}
	}		
}

function get_pages($id)
{
	global $__CMS_CONN__;
	
	$sql = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."page` WHERE `parent_id` = ".$id." && `status_id` = 100 ORDER BY `id` ASC");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$pages = $sql->fetchAll();
	if(count($pages) > 0)
	{
		foreach($pages as $k => &$pageInfo)
		{
			$pageInfo['children'] = get_pages($pageInfo['id']);
		}
	}
	return $pages;
}

function build_sitemap($array, $type, $parent_slug='/')
{
	$out = '';
	if($type != 'xml')
	{
		$out .= '<ul>';
	}
	foreach($array as $k => $page)
	{
		if($page['slug'] == '')
		{
			$link = '/';
		} else
		{
			$link = $parent_slug.$page['slug'].URL_SUFFIX;
		}
		if(substr(URL_PUBLIC, -1) == '/')
		{
			$url_public = substr(URL_PUBLIC, 0, -1);
		} else
		{
			$url_public = URL_PUBLIC;
		}	
		
		$title = stripslashes($page['title']);
		if($type != 'xml')
		{
			$out .= "<li><a href=\"".$url_public.$link."\">".$title."</a>";
		} else
		{
			$out .= "  <url>\n";
			$out .= "   <loc>".$url_public.$link."</loc>\n";
			$out .= "   <lastmod>".date('Y-m-d', strtotime($page['updated_on']))."</lastmod>\n";
			$out .= "   <changefreq>".($page['title'] == 'Home Page' ? 'Weekly' : 'Monthly')."</changefreq>\n";
			$out .= "  </url>\n";
		}
		if(count($page['children']) > 0)
		{
			$out .= build_sitemap($page['children'], $type, ($page['slug'] == '') ? '/' : $parent_slug.$page['slug']."/");
		}
		if($type != 'xml')
		{
			$out .= "</li>";
		}
	}
	if($type != 'xml')
	{
		$out .= '</ul>';
	}
	return $out;
}

// Functions below relative to MBBLOG only
// uncomment if you are using mbblog.
/*
function build_mbblog_sitemap($type)
{
	global $__CMS_CONN__;
	
	$sql = $__CMS_CONN__->prepare("SELECT * FROM `".TABLE_PREFIX."mbblog` ORDER BY `date` DESC");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$posts = $sql->fetchAll();
	if(count($posts) > 0)
	{
		$out = '';
		if($type != 'xml')
		{
			$out .= '<ul>';
		}	

		if(substr(URL_PUBLIC, -1) == '/')
		{
			$url_public = substr(URL_PUBLIC, 0, -1);
		} else
		{
			$url_public = URL_PUBLIC;
		}

		foreach($posts as $k => &$postInfo)
		{
			if($type != 'xml')
			{
				$out .= "<li><a href=\"".$url_public."/view/".$postInfo['urltitle']."\">".stripslashes($postInfo['posttitle'])."</a></li>";
			} else
			{
	            $out .= "  <url>\n";
	            $out .= "   <loc>".$url_public."/view/".$postInfo['urltitle']."</loc>\n";
	            $out .= "   <lastmod>".date('Y-m-d', $postInfo['date'])."</lastmod>\n";
	            $out .= "   <changefreq>Monthly</changefreq>\n";
	            $out .= "  </url>\n";
			}
		}
		
		if($type != 'xml')
		{
			$out .= '</ul>';
		}
	}
	return $out;
}
*/
?>