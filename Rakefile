begin
  require 'rubygems'
  gem 'jeremylightsmith-actionsite', '>= 0.6'
rescue Exception
  $: << File.dirname(__FILE__) + "/../actionsite/lib"
end
require 'action_site'

require 'spec/rake/spectask'
load 'tasks/db.rake'

task :default => [:generate, "test:links"]


def sites_to_generate
  sites = {
    "jeremy_lightsmith" => "public/jeremy_lightsmith",
    "blues_hero" => "public/blues_hero",
    "brenda" => "public/brenda",
    "challenge" => "public/jeremy_and_karissa/challenge",
    "jeremy_and_karissa" => "public/jeremy_and_karissa/",
    "jklbx" => "public/jeremy_and_karissa/exchange",
    "wedding" => "public/jeremy_and_karissa/wedding",
    "2009_blues_workshop" => "public/jeremy_and_karissa/2009/blues_workshop",
    "liltown" => "public/jeremy_and_karissa/liltown",
    "bernardo_fresquez" => "public/onemanswalk/bernardo_fresquez",
  }
  sites = sites.find_all {|name, target| name == ENV["SITE"]} if ENV["SITE"]
  raise "don't know about site : #{ENV["SITE"]}" if sites.empty?
  sites
end

desc "wordpress"
task :wordpress do
  wordpress "life",               "/life/",             "public/onemanswalk/life"
  wordpress "work",               "/work/",             "public/onemanswalk/work"
  wordpress "portland_dog_zen",   "/",                  "public/portland_dog_zen"
  wordpress "montessori",         "/montessori/",       "public/jeremy_and_karissa/montessori"
  wordpress "abby",               "/",                  "public/abby"
end

def sites_to_check
  sites_to_generate.values.
                    map {|site| site.sub(/^public\//, '')}.
                    map {|site| "http://localhost/#{site}"}
end

ActionSite::RESOURCE_EXTENSIONS << "pdf"

desc "generate the site"
task :generate do
  sites_to_generate.each do |name, target|
    ActionSite::Site.new("web/#{name}", "#{target}").generate
  end
  Rake::Task[:wordpress].invoke
end

desc "start generating"
task :start do
  raise "choose a site to serve w/ SITE=brenda, etc..." unless sites_to_generate.size == 1
  
  sites_to_generate.each do |name, target|
    ActionSite::Site.new("web/#{name}", "#{target}").serve(4444)
  end
end

desc "test links"
task "test:links" do
  links = ActionSite::AsyncLinkChecker.new
  sites_to_check.each do |site|
    links.check(site)
  end
end

desc "test links"
task "test:local_links" do
  links = ActionSite::AsyncLinkChecker.new(:local => true)
  sites_to_check.each do |site|
    links.check(site)
  end
end

def wordpress(name, uri, to)
  rm_rf to
  mkdir_p to
  root = File.expand_path(File.dirname(__FILE__))
  Dir.chdir("web/wordpress") do
    Dir["*"].each do |file|
      files = [File.join(root, "web/wordpress", file), File.join(root, to, file)]
      if file == "wp-content"
        ln_s *files
      else
        cp_r *files
      end
    end
  end
  cp_r File.join(root, "config", "wp-config.#{name}.php"), File.join(root, to, "wp-config.php")
  File.open(File.join(root, to, ".htaccess"), "w") do |f|
    f << 
"# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase #{uri}
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . #{uri}index.php [L]
</IfModule>
# END WordPress"
  end
end
