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
 * @file		enable.php
 * @date		26/12/2009
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

// include the plguin index
include("./index.php");

sitemap_generate('', 'xml');
