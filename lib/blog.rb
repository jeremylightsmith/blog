$LOAD_PATH << File.expand_path(File.dirname(__FILE__))
$LOAD_PATH << File.expand_path(File.dirname(__FILE__) + "/../../actionsite/lib")

require 'action_site'

require 'pattern'
require 'pattern_links_extension'

require 'generators/pattern_generator'
require 'generators/redcloth_with_patterns_generator'
