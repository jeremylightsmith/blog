function subarray(array, count) {
  var result = [];
  for (i = 0; i < count; i++) {
    result[i] = array[i];
  }
  return result;
}

jQuery(function() {
  jQuery.each(jQuery(".hidden"), function() {
    var content = $(this);
    content.hide();

    jQuery('<a class="read_more" href="#">(read more)</a>').click(function() {
      $(this).remove();
      content.slideDown();
      return false;
    }).appendTo(content.prev());
  })
  
  jQuery.each(jQuery(".abbreviate"), function() {
    var content = $(this);
    var synopsis_text = subarray(content.text().split(" "), 21).join(" ");
    var synopsis = $("<div>" + synopsis_text + "</div>").insertAfter(content);
    content.hide();

    jQuery('<a class="read_more" href="#">(read more)</a>').click(function() {
      synopsis.hide()
      content.show()
      return false;
    }).appendTo(synopsis)
  })
  
  jQuery.each(jQuery('.photos'), function() {
    var element = $(this)
    options = {
      api_key:"1df4861d8818ad25429e8302d6561f07",
      type:"photoset",
      thumb_size:"m",
      per_page:500
    }
    jQuery.each(['type', 'tags', 'photoset_id'], function(i, tag) {
      if (element.attr(tag)) {
        options[tag] = element.attr(tag)
      }
    })
    element.flickr(options)
  })
})