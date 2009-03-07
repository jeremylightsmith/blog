module ClassesHelper
  def hide_classes
    <<-HTML
<script type="text/javascript" charset="utf-8">
  $(function() {$('.classes').hide()})
</script>
    HTML
  end
  
  def read_more(classes)
    link_to_function "(read more)", "$('#{classes}').slideDown();$(this).toggle()"
  end
end