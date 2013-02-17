/* testovaci trida */
JAK.Test = JAK.ClassMaker.makeClass({
  NAME: "Test",
  VERSION: "1.0",
  CLASS: "class"
});

JAK.Test.prototype.$constructor = function(box) {
	alert('xxx');  
  //this.box = JAK.DOM.getElementsByClass(box);
  //for (var i=0; i < this.box.length; i++) {
    //JAK.Events.addListener(this.box[i], 'click', this, '_move');
  //}
	JAK.Events.addListener(JAK.gel('test'), 'click', this, '_test');  
}



JAK.Test.prototype._test = function(e, elm) { 
	window.location.href = "file:///Users/me/Dropbox/lab/sablona/index.html/test"; 
  
  //this.timeout = setTimeout(this._goToUrl.bind(this),1500); 
  //JAK.Events.cancelDef(e);
}