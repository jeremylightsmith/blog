require File.dirname(__FILE__) + "/lib/blog"
require 'spec/rake/spectask'
load 'tasks/db.rake'

task :default => [:spec, :generate]

Spec::Rake::SpecTask.new(:spec) do |t|
  t.spec_files = FileList['spec/**/*_spec.rb']
end

task :generate do
  generator = HtmlGenerator.new
  
  in_dir = File.dirname(__FILE__) + '/facilitation_patterns'
  out_dir = File.dirname(__FILE__) + '/public/facilitation_patterns'
  rm_rf FileList[out_dir + "/*.html"]
  
  Dir[in_dir + "/*.*"].each do |in_file|
    out_file = in_file.gsub(in_dir, out_dir).gsub(/\..+$/, '.html')
    generator.write_page(in_file, out_file)
    puts "generated #{File.basename(out_file)}"
  end
end