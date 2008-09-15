class Pattern
  MANDATORY_ATTRIBUTES = %w(category)
  OPTIONAL_ATTRIBUTES = %w(name story summary problem answer details credits todo)
  
  def initialize(symbol, options)
    options = {} if !options
    actual = options.keys.map {|k| k.to_s}
    missing = MANDATORY_ATTRIBUTES - actual
    unknown = actual - (MANDATORY_ATTRIBUTES + OPTIONAL_ATTRIBUTES)
    raise "missing options #{missing.inspect} reading #{symbol}" unless missing.empty?
    raise "unknown options #{unknown.inspect} reading #{symbol}" unless unknown.empty?

    @options = {}
    options.each do |n,v| 
      v = v.gsub("\n", "\n\n") if v.respond_to?(:gsub)
      @options[n.to_sym] = v
    end
    @options[:symbol] ||= symbol
    @options[:name] ||= symbol.to_s.titleize
  end
    
  def method_missing(sym, *args)
    if sym.to_s.ends_with?("?")
      !self.send(sym.to_s[0..-2]).blank?
    elsif @options.has_key?(sym)
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
