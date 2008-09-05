class Pattern
  def initialize(symbol, options)
    @options = {}
    options.each {|n,v| @options[n.to_sym] = v}
    @options[:symbol] ||= symbol
    @options[:name] ||= symbol.to_s.titleize
  end
    
  def method_missing(sym, *args)
    if @options.has_key?(sym)
      @options[sym]
    else
      ''
    end
  end
end

class Patterns < Array
  def [](index)
    if index.is_a?(String) || index.is_a?(Symbol)
      find {|pattern| pattern.symbol == index.to_sym }
    else
      super
    end
  end
      
  def self.load
    patterns = Patterns.new
    Dir[File.dirname(__FILE__) + '/../facilitation_patterns/*.pattern.yml'].each do |file|
      yml = YAML::load_file(file) rescue raise("error reading #{File.basename(file)}: #{$!.message}")
      patterns << Pattern.new(File.basename(file.sub(/.pattern.yml$/, '')).to_sym, yml)
    end
    patterns
  end
end
