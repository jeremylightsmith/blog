require File.dirname(__FILE__) + "/lib/blog"
require 'spec/rake/spectask'
load 'tasks/db.rake'

task :default => [:spec, :generate, :patterns, "test:links"]

Spec::Rake::SpecTask.new(:spec) do |t|
  t.spec_files = FileList['spec/**/*_spec.rb']
end

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

desc "generate the facilitation_patterns site"
task :patterns do
  Dir.chdir(File.dirname(__FILE__)) do
    site = ActionSite::Site.new("web/facilitation_patterns", "public/facilitation_patterns")
    
    site.generators["pattern"] = Generators::PatternGenerator.new
    site.generators["red"] = Generators::RedclothWithPatternsGenerator.new
    
    site.context.patterns = Patterns.load("web/facilitation_patterns")
    site.context.patterns_by_category = {}
    site.context.patterns.each do |pattern|
      (site.context.patterns_by_category[pattern.category] ||= []) << pattern
    end
    
    site.generate
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
    facilitation_patterns
  )
end

desc "test links"
task "test:links" do
  links = ActionSite::LinkChecker.new
  sites_to_check.each do |path|
    links.check("http://localhost/#{path}/")
  end
end

desc "test links"
task "test:local_links" do
  links = ActionSite::LinkChecker.new(:local => true)
  sites_to_check.each do |path|
    links.check("http://localhost/#{path}/")
  end
end
