INSTALLATION
=================

To setup and use mbSitemap, you first need to download the plugin which can be found here.
Once downloaded, unzip the contents into the plugin folder of your Wolf Installation (Default will be /wolf/plugins/). Then you will need to create a sitemap.xml file in the root directory of your website, this file will need to be chmod to 0777.

Next you will need to activate the plugin. Do this as you would a normal plugin via the administration tab in your wolfCMS admin area. Upon enabling mbSitemap, the plugin will compile your pages and build an xml sitemap which will be written to the sitemap.xml file you created earlier. Normally xml sitemaps are for search engines but if you wish to link to it, it will be found at http://www.yourdomain.com/sitemap.xml.

The html sitemap is created on-the-fly when someone visits the page. To set this up you will need to create a page called "sitemap", turn filters off and put the following code into the body then save your page.

<?php sitemap_generate('', 'html'); ?>
If you don't want the page to appear in your main menu, set the status to hidden. If the page was created as a child of the homepage, then by default you should be able to access the html sitemap by visiting http://www.yourdomain.com/sitemap.html. (Extension may vary if you have edited your config, this will be reflected in mbSitemap).

STYLING
=========

The html sitemap can be styled easily by utilizing css. Using the sitemap for my site as an example, you should be able to work out the css needed to style the sitemap list by looking at the sitemap structure below.


`<div class="sitemap">
	<ul>
		<li><a href="http://www.mikebarlow.co.uk/">Home Page</a>
			<ul>
				<li><a href="http://www.mikebarlow.co.uk/about_us.html">About</a></li>
				<li><a href="http://www.mikebarlow.co.uk/contact.html">Contact</a></li>
				<li><a href="http://www.mikebarlow.co.uk/projects.html">Projects</a>
					<ul>
						<li><a href="http://www.mikebarlow.co.uk/projects/mbblog-roadmap.html">mbBlog Roadmap</a></li>
						<li><a href="http://www.mikebarlow.co.uk/projects/mbblog-documentation.html">mbBlog Documentation</a></li>
						<li><a href="http://www.mikebarlow.co.uk/projects/mbsitemap-documentation.html">mbSitemap Documentation</a></li>
					</ul>
				</li>
				<li><a href="http://www.mikebarlow.co.uk/tutorials.html">Tutorials</a>
					<ul>
						<li><a href="http://www.mikebarlow.co.uk/tutorials/age-calculation.html">Age Calculation</a></li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
	<ul>
		<li><a href="http://www.mikebarlow.co.uk/?bid=12">New Project / Update Project</a></li>
		<li><a href="http://www.mikebarlow.co.uk/?bid=10">Quick Update</a></li>
		<li><a href="http://www.mikebarlow.co.uk/?bid=9">New Tutorial</a></li>
		<li><a href="http://www.mikebarlow.co.uk/?bid=8">Welcome</a></li>
	</ul>
</div>`