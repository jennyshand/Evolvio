
"use strict";


        window.onload = function()
                        {
                            var myButton = document.getElementById("seeEffect");

                            myButton.onclick = whatEffect;
                        };

function whatEffect()
{
    var effectVal = document.getElementById("effect");

    effectVal = effectVal.innerHTML;
    var effectOut = document.getElementById("effect2");

    if (effectVal == -1)
    {
        effectOut.innerHTML = "harm";
    }
    else if (effectVal == 1)
    {
        effectOut.innerHTML = "benefit";
    }
    else
    {
        effectOut.innerHTML = "no effect";
    }

}


