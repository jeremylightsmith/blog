class SiteGenerator  
  def initialize(in_dir, out_dir)
    @generator = HtmlGenerator.new(in_dir)
    @in_dir, @out_dir = in_dir, out_dir
    puts "\nGENERATING #{File.basename(in_dir).upcase}\n\n"
    rm_rf out_dir
    mkdir_p out_dir
  end
  
  def generate(in_dir = @in_dir, out_dir = @out_dir)
    Dir[in_dir + "/*"].each do |in_file|
      out_file = in_file.gsub(in_dir, out_dir)

      if excluded?(in_file)
        # nothing
        
      elsif File.symlink?(in_file)
        cp in_file, out_file rescue nil # maybe the links don't exist here

      elsif File.directory?(in_file)
        mkdir_p out_file
        generate in_file, out_file
      
      elsif resource?(in_file)
        ln_s File.expand_path(in_file), File.expand_path(out_file)

      else 
        out_file = out_file.gsub(/\..+$/, '.html')
        @generator.write_page(in_file, out_file)
        puts "   #{in_file} => #{out_file}"
      end
    end
  end
  
  def excluded?(file)
    File.directory?(file) && %w(layouts helpers).include?(File.basename(file))
  end
  
  def resource?(file)
    %w(css ico gif jpg png js).include?(file.extension)
  end
end