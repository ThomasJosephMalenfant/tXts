// Ajoute un intercepteur charcode = "+" => "      " sur éléments de classe "editeur"

editeurs = document.getElementsByClassName("editeur") ;
l = editeurs.length;
for (i = 0; i < l; i++) {
    editeurs[i].addEventListener("keydown", function (ev) {
        if(ev.code == "NumpadAdd" ){
            ev.preventDefault();
            var tabulation = "        " ;
            var sel, range, textNode;
            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();
                    textNode = document.createTextNode(tabulation);
                    range.insertNode(textNode);

                    // Move caret to the end of the newly inserted text node
                    range.setStart(textNode, textNode.length);
                    range.setEnd(textNode, textNode.length);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            } else if (document.selection && document.selection.createRange) {
                range = document.selection.createRange();
                range.pasteHTML(tabulation);
            }
        } 
    });
}
