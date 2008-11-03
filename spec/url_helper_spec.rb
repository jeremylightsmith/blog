require File.dirname(__FILE__) + '/spec_helper'

describe UrlHelper do
  include UrlHelper
  
  describe "#link_to" do
    it "should show a link" do
      link_to("foo", "http://google.com").should == 
        '<a href="http://google.com">foo</a>'
    end
    
    it "should put optional params into the html" do
      link_to("a", "/b", :class => "my").should == '<a href="/b" class="my">a</a>'
      link_to("a", "/b", :size => 5).should == '<a href="/b" size="5">a</a>'
    end
  end
  
  describe "#image_tag" do
    it "should show an image" do
      image_tag("foo.png").should == %{<img src="foo.png"/>}
    end

    it "should show an image" do
      image_tag("foo.png", :class => 'foo').should == %{<img src="foo.png" class="foo"/>}
    end
  end
end