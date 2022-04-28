function popupMessageBlockList() {
	var currentKeys = getCookie("popup-message");
	if (currentKeys) {
		currentKeys = JSON.parse(currentKeys);
		return currentKeys;
	}
	return [];
}

function addPopupMessageToBlockList() {
	var container = document.getElementById("popup-message-outer");
	var popupMessage = container.getElementsByClassName("popup-message");
	var messageKey = popupMessage[0].getAttribute("key");
	if (popupMessage.length > 0) {
		if (messageKey) {
			var messageKeys = [messageKey];
			console.log(messageKeys);
			
			var currentKeys = popupMessageBlockList();
			if (!currentKeys.includes(messageKey)) {
				messageKeys = messageKeys.concat(currentKeys);
			}
		
			console.log(messageKeys);
			writeCookie("popup-message", JSON.stringify(messageKeys), 1);
		}
	}
	
	dismissPopupMessage();
}

function dismissPopupMessage() {
	//console.log("container clicked");
	container = document.getElementById("popup-message-outer");
	container.classList.remove("important");
	container.classList.remove("image");
    document.body.classList.remove("popup-message-showing");
	
	var popupMessage = container.getElementsByClassName("popup-message");
	if (popupMessage.length > 0) {
		container.removeChild(popupMessage[0]);
	}
	showPopupMessage();
}

function showPopupMessage(message = null) {
	if (!document.body.classList.contains("popup-message-showing")) {
      if (message) {
          const div = document.createElement("div");
          div.classList.add("popup-message");
		  div.setAttribute("important", true);
          div.innerHTML = message;
          document.body.appendChild(div);
      }
	  var popupMessage = document.getElementsByClassName("popup-message");
	  console.log(popupMessage);
	  if (popupMessage.length > 0) {
		var item = popupMessage[0];
		var messageKey = item.getAttribute("key");
		var url = item.getAttribute("url");
		var expires = item.getAttribute("expires");
		var important = item.getAttribute("important");
		var isImage = item.getAttribute("isImage");
		
		if (expires) {
			expires = new Date(expires);
		}
		console.log("key: " + messageKey + ", url: " + url + ", expires: " + expires + " important: " + important + " " + (important == "true"));
	
		if 	(
				(!url || (url && equalUrls(url, window.location)) ) &&
				(!popupMessageBlockList().includes(messageKey)) &&
				(!expires || (expires > new Date()))
			) {
			item.classList.add("centered");
		    var container = document.getElementById("popup-message-outer");
		    document.body.classList.add("popup-message-showing");
		    container.appendChild(item);

			if (important == "true") {
				container.classList.add("important");
				//console.log(container);
			}
			if (isImage == "true") {
				container.classList.add("image");
			}
		}
		else {
			item.parentNode.removeChild(item);
			showPopupMessage();
		}
	  }
	}
}

function showTopMessage() {
	var topMessage = document.getElementsByClassName("top-message");
	var container = document.getElementById("top-message-container");
	var demo = document.getElementById("top-message-outer-demo");
	
	if (!container.hasChildNodes()) {
		for (let item of topMessage) {
			var url = item.getAttribute("url");
			if (url == null || (url && equalUrls(url, window.location))) {
				var messageOuter = demo.cloneNode(true);
				messageOuter.classList.remove("demo");
				messageOuter.appendChild(item);
				container.appendChild(messageOuter);
			}
		}
	}
}

function equalUrls(url1, url2) {
  return (
  	url1 && url2 &&
    new URL(url1, "http://example.com").pathname ===
    new URL(url2, "http://example.com").pathname
  );
}

function removeDuplicateWidgets() {
	let duplicates = document.querySelectorAll('#page_body:not(:first-of-type) > #HTML4');
	for (let item of duplicates) {
		item.parentNode.removeChild(item);
	}
}

function initImg() {
	if (document.body.classList.contains("item-view")) {
		let postBody = document.body.querySelector("[id^='post']");
		let imgs = postBody.querySelectorAll("a > img:only-child");
		//console.log(imgs);
		var i = 0;
		for (let img of imgs) {
			let a = img.parentNode;
			a.setAttribute("onclick", "showPopupImage(event, this, this.id)");
			a.setAttribute("id", "post-body-img-" + i);
			i++;
		}
	}
}

function showPopupImage(e, a, id = null) {
	e.preventDefault();
	dismissPopupMessage();

	let popupMsg = document.createElement("div");
	popupMsg.setAttribute("class", "popup-message post-body img-loading");
	popupMsg.setAttribute("important", true);
	popupMsg.setAttribute("style", "text-align: center; position: relative");
	popupMsg.setAttribute("isImage", "true");

	if (id) {
		a = document.getElementById(id);
	}
	
	let blockquote = a.closest("blockquote");
	if (blockquote) {
		popupMsg.innerHTML = blockquote.innerHTML;
	}
	else {
		popupMsg.innerHTML = a.outerHTML;
	}

	let imgOlds = popupMsg.querySelectorAll('a > img:only-child');
	let imgId = "";
	for (let imgOld of imgOlds) {
		let aEl = imgOld.parentNode;
		imgOld.classList.add("placeholder");
		aEl.setAttribute("target", "_blank");
		aEl.href = aEl.href.replace("www.qingsky.hk", "aws.qwinna.hk").replace("dev.qingsky.hk", "aws.qwinna.hk").replace("-scaled", "");
		aEl.removeAttribute("onclick");
		
		let imgNew = document.createElement("img");
		imgNew.setAttribute("onload", "removePlaceHolder(this); hidePageLoading()");
		imgNew.setAttribute("onerror", "removePlaceHolder(this); hidePageLoading()");
		imgNew.setAttribute("src", aEl.href);
		imgOld.parentNode.insertBefore(imgNew, imgOld);
		
		imgId = aEl.getAttribute("id");
	}
	
	let nav = document.createElement("div");
	nav.classList.add("popup-img-navigation");
	let svg = '<svg class="svg-icon-24" style="height: 30px; width: 30px; " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M88 352C110.1 352 128 369.9 128 392V440C128 462.1 110.1 480 88 480H40C17.91 480 0 462.1 0 440V392C0 369.9 17.91 352 40 352H88zM280 352C302.1 352 320 369.9 320 392V440C320 462.1 302.1 480 280 480H232C209.9 480 192 462.1 192 440V392C192 369.9 209.9 352 232 352H280zM40 320C17.91 320 0 302.1 0 280V232C0 209.9 17.91 192 40 192H88C110.1 192 128 209.9 128 232V280C128 302.1 110.1 320 88 320H40zM280 192C302.1 192 320 209.9 320 232V280C320 302.1 302.1 320 280 320H232C209.9 320 192 302.1 192 280V232C192 209.9 209.9 192 232 192H280z"/>';
	nav.appendChild(getPopupImageOffsetLink(imgOlds[0].parentNode.id, -1));
	nav.innerHTML += "<a class='flat-button' onclick='showThumbnails(event, \""+ a.id +"\");'>" + svg + "</a>";
	nav.appendChild(getPopupImageOffsetLink(imgOlds[imgOlds.length - 1].parentNode.id, 1));

	document.body.appendChild(popupMsg);
	showPageLoading();
	showPopupMessage();
	
	let bottomButtons = document.getElementById("popup-message-bottom-button");
	let importantButton = document.getElementById("popup-message-dismiss-button");
	bottomButtons.innerHTML = "";
	bottomButtons.appendChild(importantButton);
	bottomButtons.appendChild(nav);
}

function getPopupImageOffsetLink(imgId, offset = 1, text = "next") {
	let id = "post-body-img-" + (parseInt(imgId.replace("post-body-img-", "")) + parseInt(offset));
	let link = document.querySelector("#main #" +id);
    let a = document.createElement("a");
	a.classList.add("flat-button");

	let svgNext = document.createElement("svg");
	svgNext.setAttribute("viewBox", "0 0 384 512");
	svgNext.setAttribute("class", "svg-icon-24");
	svgNext.innerHTML = '<path d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"/>';
	console.log(svgNext);
	if (link) {
		if (offset < 0) {
			svgNext.setAttribute("style", "transform: scaleX(-1)");
		}
	    a.innerHTML += svgNext.outerHTML;
	    a.setAttribute("onclick", "dismissPopupMessage(); showPopupImage(event, this, '" + id + "')");
	}
	return a;
}

function showThumbnails(e, id = null) {
	e.preventDefault();
	if (id && document.getElementById("popup-img-thumbnail")) {
		dismissPopupMessage();
		showPopupImage(e, null, id);
		return;
	}
	dismissPopupMessage();

	let popupMsg = document.createElement("div");
	popupMsg.setAttribute("class", "popup-message post-body");
	popupMsg.setAttribute("important", true);
	popupMsg.setAttribute("style", "text-align: center");
	popupMsg.setAttribute("isImage", "true");

	let postBodyImgs = document.querySelectorAll('#main a > img:only-child[src]');
	let thumbDiv = document.createElement("div");
	thumbDiv.id = "popup-img-thumbnail";
	thumbDiv.classList.add("thumbnail");
	thumbDiv.innerHTML = "";
	for (let img of postBodyImgs) {
		let imgNew = document.createElement("img");
		imgNew.src = img.src;
		imgNew.srcset = img.srcset;

		let a = img.parentNode;
		let aNew = document.createElement("a");
		aNew.href = a.href;
		aNew.setAttribute("onclick", a.getAttribute("onclick"));
		aNew.id = a.id;
		aNew.appendChild(imgNew);
		
		thumbDiv.appendChild(aNew);
	}
	popupMsg.appendChild(thumbDiv);
	document.body.appendChild(popupMsg);

	showPopupMessage();
}

function removePlaceHolder(img) {
	//img.parentNode.removeChild(img.parentNode.querySelector("img.placeholder"));
	const popupMsg = img.closest("div.popup-message");
	popupMsg.classList.remove("img-loading");
}
function removePlaceHolderClass(img) {
	let ph = img.parentNode.querySelector("img.placeholder");
	ph.classList.remove("placeholder");
}

ready(function () {
	removeDuplicateWidgets();
	showPopupMessage();
	showTopMessage();
	initImg();
});