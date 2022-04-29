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
	container.classList.remove("important", "image", "thumbnail", "archive");
    document.body.classList.remove("popup-message-showing");
	
	var popupMessage = container.getElementsByClassName("popup-message");
	if (popupMessage.length > 0) {
		container.removeChild(popupMessage[0]);
	}
	showPopupMessage();
}

function showPopupMessage(message = null) {
	if (!document.body.classList.contains("popup-message-showing")) {
	  var popupMessage = document.getElementsByClassName("popup-message");
	  console.log(popupMessage);
	  if (popupMessage.length > 0) {
		var item = popupMessage[0];
		var messageKey = item.getAttribute("key");
		var url = item.getAttribute("url");
		var expires = item.getAttribute("expires");
		var important = item.getAttribute("important");
		const classOuter = item.getAttribute("class-outer");
		// var isImage = item.getAttribute("isImage");
		// var isArchive = item.getAttribute("isArchive");
		
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
				container.classList.add("important")
			}
			if (classOuter) {
				let classes = classOuter.split(" ");
				container.classList.add(...classes);
			}
		}
		else {
			item.parentNode.removeChild(item);
			showPopupMessage();
		}
	  }
	  else {
		if (message) {
			if (typeof(message) == "string") {
				const div = document.createElement("div");
				div.classList.add("popup-message");
				div.setAttribute("important", true);
				div.innerHTML = message;
				document.body.appendChild(div);
			}
			else {
				message.classList.add("popup-message");
				message.setAttribute("important", true);
				document.body.appendChild(message);
			}
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
	// popupMsg.setAttribute("isImage", "true");
	popupMsg.setAttribute("class-outer", "image");

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
	
	document.body.appendChild(popupMsg);
	showPageLoading();
	showPopupMessage();
	let nav = document.getElementById("popup-img-navigation").cloneNode(true);
	
	let bottomButtons = document.getElementById("popup-message-bottom-button");
	let importantButton = document.getElementById("popup-message-dismiss-button");
	bottomButtons.innerHTML = "";
	bottomButtons.appendChild(importantButton);
	bottomButtons.appendChild(nav);

	getPopupImageOffsetLink(imgOlds[0].parentNode.id, -1, document.querySelector("#popup-message-bottom-button #popup-img-navigation-prev"));
	getPopupImageOffsetLink(imgOlds[imgOlds.length - 1].parentNode.id, 1, document.querySelector("#popup-message-bottom-button #popup-img-navigation-next"));
	document.querySelector("#popup-message-bottom-button #popup-img-navigation-thumbnail").setAttribute("onclick", 'showThumbnails(event, \"'+ a.id +'\");');
}

function getPopupImageOffsetLink(imgId, offset = 1, node = null) {
	let id = "post-body-img-" + (parseInt(imgId.replace("post-body-img-", "")) + parseInt(offset));
	let link = document.querySelector("#main #" +id);
    // console.log(node);
	if (node) {
		if (link) {
			node.style.visibility = "visible";
			node.setAttribute("onclick", "dismissPopupMessage(); showPopupImage(event, this, '" + id + "')");
		}
		else {
			node.style.visibility = "hidden";
		}
	}
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
	popupMsg.setAttribute("class-outer", "image thumbnail");

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
	// if (id) {
	// 	console.log("#popup-img-thumbnail #" + id);
	// 	document.body.scrollIntoView(document.querySelector("#popup-img-thumbnail #" + id));
	// }
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

function togglePopupArchive(year, month) {
	// document.body.classList.toggle("popup-archive-showing");
	const popupArchive = document.getElementById("popup-archive").cloneNode(true);
	popupArchive.classList.add("popup-message");
	popupArchive.setAttribute("important", true);
	// popupArchive.setAttribute("isArchive", true);
	popupArchive.setAttribute("class-outer", "archive");
	document.body.appendChild(popupArchive);
	showPopupMessage();
	if (year) {
		document.querySelector(".popup-message #popup-archive-text-year").innerText = year;
		setSelectToValue("popup-archive-select-year", year);
	}
	if (month) {
		document.querySelector(".popup-message #popup-archive-text-month").innerText = month;
		setSelectToValue("popup-archive-select-month", month);
	}
	updateGotoLink();
}

function setSelectToValue(selectId, value) {
	var select = document.querySelector(".popup-message #" + selectId);
	if (select) {
		var opts = select.options;
		for (var opt, j = 0; opt = opts[j]; j++) {
			if (opt.value == value) {
				select.selectedIndex = j;
				break;
			}
		}
	}
}

function changeDisplayText(select) {
	if (select.id == "popup-archive-select-year") {
		document.getElementById("popup-archive-text-year").innerText = select.value;
	}
	else if (select.id == "popup-archive-select-month") {
		document.getElementById("popup-archive-text-month").innerText = select.value;
	}
}

function updateGotoLink() {
	var gotoLink = document.getElementById("popup-archive-goto-link");
	var url = "/";
	var year = document.getElementById("popup-archive-select-year").value;
	var month = document.getElementById("popup-archive-select-month").value;
	if (month < 10) {
		month = "0" + month;
	}
	gotoLink.href = url + year + "/" + month + "/";
	gotoLink.setAttribute("onclick", "return gotoUrlWithDelay('" + gotoLink.href + "');");
}



ready(function () {
	removeDuplicateWidgets();
	showPopupMessage();
	showTopMessage();
	initImg();
});

