module ClassesHelper
  def all_classes
    <<-HTML
<h3>General Classes #{read_more ".general.classes"}</h3>

<div class="general classes">
Feedback Class
Great as a masters class, an elective, or as a tool for teacher training.  They are common at WCS events and in Invitational tracks at other Swing and Blues events.  The idea is to give pointers to individuals as the class observes so they can all benefit from each other's notes. Seeing and hearing another dancer being critiqued can help us learn something we might not be able to in a typical group class, or in a private lesson of our own.  Bring a notepad and pen and check your ego at the door.  This class is open to any dance style.

Solo Movement 
Applicable to all dance styles. We use isolations and exercises to create integration and control in our dance movement. The better we dance as individuals the more we offer as partners.
</div>

<h3>Blues Classes #{read_more ".blues.classes"}</h3>

<div class="blues classes">
Beg/Int

Class I
Blues Foundations
Brenda will cover basic leg and hip action for Blues, as well as a traditional dance pattern for moving with your partner.

Class II
Blues Vocabulary
Using the basic structures established in Class I, we will continue on refining our technique and incorporating various rhythms, maneuvers, and turns.

Adv

Class I
From Foundations to Frame Changes
Brenda will cover her basic Blues Foundation steps creating common building blocks for the class, then continue into promenade and offline navigating, creating a diverse and complex dance repertiore.

Class II
Fancy Turns, Dips, and Skips
We will create sequences of advanced movements working through techniques and transitions along the way.

Beg/Int or Adv

Class III
Isolations, Shaping, and Leverage
We will add depth and texture to our dancing by exploring and mastering the illusive characteristics of partner dancing.

Rhythm and Movement
This class will focus on expanding your vocabulary of rhythms in your blues dancing and how to use the different rhythms to create new directional patterns.  This is a vocabulary expander for both leads and follows independently and together.

African Dance Movement for Blues
We will cover several African dance moves and put them into our Blues dancing with partners.  They can also be used individually in your solo or partner dancing.

Pivots, Spins, and Turns
We will drill several types of turn technique to build strength and muscle memory, then put the concepts into our partnering and solo dancing
</div>

<h3>West Coast Swing Classes #{read_more ".wcs.classes"}</h3>

<div class="wcs classes">
WCS
We will start with fundamental West Coast Swing patterns to make the class friendly for all dancers, then create interesting variations as well as offer specific styling and technique tips for an authentic look and feel.  If you already know WCS please come help the other dancers in the class, you might pick up a tip or two as well!

Beg WCS: Basics of Rhythm and Connection
Beg WCS: Leg Action & Body Shaping for a Smooth Look & Feel
Int WCS: Single Tracking and Turning Techniques
Int WCS: New Twists on Old Patterns
</div>

<script type="text/javascript" charset="utf-8">
  $(function() {$('.classes').hide()})
</script>
    HTML
  end
  
  
  def read_more(classes)
    link_to_function "(read more)", "$('#{classes}').slideDown();$(this).toggle()"
  end
end