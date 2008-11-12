require File.dirname(__FILE__) + '/../spec_helper'

describe Helpers::UrlHelper do
  include Helpers::UrlHelper
  
  describe "#link_to" do
    it "should show a link" do
      link_to_function("foo", "alert('you')").should == 
        %{<a href="#" onclick="alert('you');return false;">foo</a>}
    end
  end
  
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
    it "should show an image from images/" do
      image_tag("foo.png").should == %{<img src="images/foo.png"/>}
    end

    it "should not prepend images/ to fully qualified urls" do
      image_tag("http://foo/foo.png").should == %{<img src="http://foo/foo.png"/>}
    end

    it "should show an image" do
      image_tag("foo.png", :class => 'foo').should == %{<img src="images/foo.png" class="foo"/>}
    end
  end
  
  describe "#stylesheet_link_tag" do
    it "should work" do
      stylesheet_link_tag(:intro, :media => :all).should == 
        '<link href="stylesheets/intro.css" rel="stylesheet" type="text/css" media="all">'
    end
  end
end