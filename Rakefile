$LOAD_PATH << File.expand_path(File.dirname(__FILE__) + "/lib")
require 'dependencies'
require 'html_generator'
load 'tasks/db.rake'

task :default => :generate

task :generate do
  generator = HtmlGenerator.new
  
  in_dir = File.dirname(__FILE__) + '/facilitation_patterns'
  out_dir = File.dirname(__FILE__) + '/public/facilitation_patterns'
  rm_rf out_dir + "/*.html"
  
  Dir[in_dir + "/*.*"].each do |in_file|
    out_file = in_file.gsub(in_dir, out_dir).gsub(/\..+$/, '.html')
    generator.write_page(in_file, out_file)
    puts "generated #{File.basename(out_file)}"
  end
end