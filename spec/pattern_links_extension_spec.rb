require File.dirname(__FILE__) + '/spec_helper'

describe PatternLinksExtension do
  attr_reader :patterns
  
  before do
    @patterns = Patterns.new
    @patterns << Pattern.new(:foo_bar, :category => 'stuff')
    @patterns << Pattern.new(:your_mom, :name => 'Bertha', :category => 'stuff')
  end
  
  it "should know about pattern links" do
    to_html("some stuff and [your_mom]").should == 
      "<p>some stuff and <a href='your_mom.html' class='pattern_link'>[Bertha]</a></p>"
  end
  
  it "should handle patterns it doesn't know about" do
    to_html("some stuff and [my_mom]").should == 
      "<p>some stuff and <span class='unknown_pattern_link'>[my_mom?]</span></p>"
  end
  
  def to_html(textile)
    redcloth = RedCloth.new(textile)
    redcloth.patterns = @patterns
    redcloth.to_html(:textile, :refs_patterns)
  end
end