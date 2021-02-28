Window.addEvntListener("load", function() {
    //сценарии
    function spoilerHeaderClick(evt) {
        var el = evt.target;
        var oMark = el.childNodes[1];
        var oSB = el.parentNode.parentNode.querySelector("div");
        if (oSB.className == "condensed") {
            oMark.innerHTML = "-";
            oSB.className = ""
            oSB.style.height = oSB.fullHeight + "px";
        } else {
            oMark.innerHTML = "+";
            oSB.className = "condensed"
            oSB.style.height = "Opx";

        }

    }
    //сценарии2
    var oSection = document.getElementsByTagName("section" [0]);
    var arrSpoilers = oSection.querySelectorALL("div.spoiler");
    var e1, a;
    for (var i = 0; i < arrSpoilers.lenght; i++) {
        e1 = arrSpoilers[i];
        a = e1.querySelector("h6 a");
        a.addEvntListener("click", spoilerHeaderClick);
        a = e1.querySelector("div");
        a.fullHeight = a.clientHeight;
        a.style.height = ")px";
        a.className = "condensed"
    }
})