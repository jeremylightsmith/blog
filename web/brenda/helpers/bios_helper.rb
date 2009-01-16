module BiosHelper
  def all_bios
    [general_bio, blues_bio].join("\n\n")
  end
  
  def blues_bio
    bio "Blues Bio",
"Brenda is fulfilling her childhood dream as a professional dancer and instructor. She studies African American street dances from the turn of the century to the present.  Brenda travels around the world teaching and training with various coaches and historians. Her strength is breaking down the dances in a way that is accessible for anyone, even if they don't have a dance background.  She strives to help her students find the dancer with-in themselves, taking inspiration from dancers of the past.  Brenda is working with the Blues dance community during this time of growth to develop curriculum and events that raise the community's level of dancing.  Her hope is to provide structure for duplicable material, while keeping the inherent character and nature of the dance."
  end
  
  def general_bio
    bio "General Bio",
"Brenda is fulfilling her childhood dream as a professional dancer and instructor.  Brenda's early dance training included about 30 dance styles.  She has also studied musical history and theory, dance history, dance instruction, several physical health methods, and other related subjects adding to her knowledge of the body, dance, music, and teaching.  Brenda continues to study and train with coaches, historians, and practitioners, always striving to increase her understanding and ability.

Brenda has put the majority of her focus over the past many years into the Lindy Hop, Balboa, Blues, West Coast Swing, and Salsa communities.  She believes we are all born with dance in our bodies, and that each of us can use this activity as a means for personal expression, connecting with others, and exercise.   Brenda loves the image of being able to dance anytime, anywhere, to any music, alone, or with anyone.  She spends her time living this dream for herself while assisting her students in accomplishing their personal dance goals."
  end
  
  def bio(name, copy)
    "<div class='bio'>
<h3>#{name}</h3>
<div class='excerpt'>

#{excerpt(copy)} #{link_to_function "read more", "$(this).parent().parent().parent().addClass('full_text')"}

</div>
<div class='full_text'>

#{copy}

</div>
</div>

"
  end
  
  def excerpt(copy)
    copy.split(" ")[0..20].join(" ") + "..."
  end
end