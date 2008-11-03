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
    sites = %w(blues_hero challenge facilitation_patterns)
    sites = [ENV["SITE"]] if ENV["SITE"]
      
    sites.each do |site|
      SiteGenerator.new("web/#{site}", "public/#{site}").generate
    end
  end
end