require File.dirname(__FILE__) + "/lib/blog"
require 'spec/rake/spectask'
load 'tasks/db.rake'

task :default => [:spec, :generate]

Spec::Rake::SpecTask.new(:spec) do |t|
  t.spec_files = FileList['spec/**/*_spec.rb']
end

desc "generate the site"
task :generate do
  Dir.chdir(File.dirname(__FILE__)) do
    sites = {
      "blues_hero" => "public/blues_hero",
      "challenge" => "public/jeremy_and_karissa/challenge",
      "facilitation_patterns" => "public/facilitation_patterns",
      "jeremy_and_karissa" => "public/jeremy_and_karissa/",
      "jklbx" => "public/jeremy_and_karissa/exchange",
      "wedding" => "public/jeremy_and_karissa/wedding",
    }
    sites = sites.find_all {|name, target| name == ENV["SITE"]} if ENV["SITE"]
    raise "don't know about site : #{ENV["SITE"]}" if sites.empty?
      
    sites.each do |name, target|
      SiteGenerator.new("web/#{name}", "#{target}").generate
    end
  end
end