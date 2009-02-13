begin
  require 'rubygems'
  gem 'jeremylightsmith-actionsite', '>= 0.3'
rescue Exception
  $: << File.dirname(__FILE__) + "/../actionsite/lib"
end
require 'action_site'

require 'spec/rake/spectask'
load 'tasks/db.rake'

task :default => [:generate, "test:links"]

desc "generate the site"
task :generate do
  ActionSite::RESOURCE_EXTENSIONS << "pdf"
  
  Dir.chdir(File.dirname(__FILE__)) do
    sites = {
      "blues_hero" => "public/blues_hero",
      "brenda" => "public/brenda",
      "challenge" => "public/jeremy_and_karissa/challenge",
      "jeremy_and_karissa" => "public/jeremy_and_karissa/",
      "jklbx" => "public/jeremy_and_karissa/exchange",
      "wedding" => "public/jeremy_and_karissa/wedding",
      "bernardo_fresquez" => "public/onemanswalk/bernardo_fresquez",
    }
    sites = sites.find_all {|name, target| name == ENV["SITE"]} if ENV["SITE"]
    raise "don't know about site : #{ENV["SITE"]}" if sites.empty?
      
    sites.each do |name, target|
      ActionSite::Site.new("web/#{name}", "#{target}").generate
    end
  end
end

def sites_to_check
  return [ENV["SITE"]] if ENV["SITE"]
  
  return %w(
    blues_hero 
    brenda 
    jeremy_and_karissa/challenge 
    jeremy_and_karissa/exchange 
    jeremy_and_karissa/wedding 
    onemanswalk/bernardo_fresquez 
  )
end

desc "test links"
task "test:links" do
  links = ActionSite::AsyncLinkChecker.new
  sites_to_check.each do |path|
    links.check("http://localhost/#{path}/")
  end
end

desc "test links"
task "test:local_links" do
  links = ActionSite::AsyncLinkChecker.new(:local => true)
  sites_to_check.each do |path|
    links.check("http://localhost/#{path}/")
  end
end
