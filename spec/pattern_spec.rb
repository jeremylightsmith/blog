require File.dirname(__FILE__) + '/spec_helper'
require 'pattern'

describe Pattern do
  it "should load all including fishbowl" do
    fishbowl = Patterns.load[:fishbowl]
    fishbowl.should_not be_nil
    fishbowl.name.should == "Fishbowl"
    fishbowl.summary.should == "A fishbowl is a way of allowing small to large (100+) groups to have a rich interpersonal dialogue by only allowing a small rotating number of people to talk at a time."
  end
  
  it "should load from yaml" do
    pattern = Pattern.new(:a_pattern, :summary => 'my summary')
    pattern.name.should == "A Pattern"
    pattern.summary.should == "my summary"
  end
end