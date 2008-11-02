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
    SiteGenerator.new("web/facilitation_patterns", "public/facilitation_patterns").generate
    SiteGenerator.new("web/challenge", "public/challenge").generate
  end
end