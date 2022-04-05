// blog-ui-ajax-dev.js

var timer = 0;
// var ori;
function showPageLoading(ajax = false) {
  if (ajax) {
    document.body.classList.add("page-loading", "ajax-loading");
  }
  else {
    document.body.classList.add("page-loading");
  }
  var el = document.getElementById('loading-bar');
  if (el) {
    el.style.animation = 'none';
    el.offsetHeight; /* trigger reflow */
    el.style.animation = null; 
  }
}

function hidePageLoading(delay = 1000) {
  if (delay > 0) {
    if (document.body.classList.contains('page-loading')) {
      document.body.classList.remove('page-loading', 'ajax-loading');
      document.body.classList.add('page-loading-end');
    }
  }
  else {
    document.body.classList.remove('page-loading', 'ajax-loading');
  }
}

function gotoUrlWithDelay(url, delay = 100, animated = true) {
  if (animated) {
    showPageLoading();
  }
  setTimeout(function () {
    window.location.href = url;
  }, delay);
  return false;
}

function ready(fn) {
  if (document.readyState != 'loading') {
    fn();
  } else if (document.addEventListener) {
    document.addEventListener('DOMContentLoaded', fn);
  } else {
    document.attachEvent('onreadystatechange', function () {
      if (document.readyState != 'loading')
        fn();
    });
  }
}

ready(function () {
  //makeExternalLinkOpenInBlank();
  init();
  fixDropboxImgSrc();
  convertScrollPosJson();
});

function fixDropboxImgSrc() {
  var imgEls = document.querySelectorAll('img');
  for (var i = 0; i < imgEls.length; i++) {
      var src = imgEls[i].getAttribute("src");
      if (src && src.includes("www.dropbox.com")) {
          imgEl[i].setAttribute("onerror", "replaceDropboxLink(this)");
          // console.log(imgEls[i]);
      }
  }
}

function replaceDropboxLink(img) {
  console.log("onerror");
  var newSrc = img.src.replace("www.dropbox.com", "dl.dropboxusercontent.com");
  if (img.src != newSrc) {
    img.setAttribute("src", newSrc);
  }
  else {
    img.removeAttribute("onerror");
  }
}

function makeExternalLinkOpenInBlank() {
  setupLinks();
}
function setupLinks() {
  console.log("now uses bubble callback / handleLink");
}

function findLink(el) {
  if (el.tagName == 'A' && el.href) {
      return el;
  } else if (el.parentElement) {
      return findLink(el.parentElement);
  } else {
      return null;
  }
};

function handleLink(anchorEl) {
  if (anchorEl.getAttribute('target')) {
    // _blank
    return true;
  }
  
  if (anchorEl.classList.contains("ajax-load-home")) {
    ajaxLoad(anchorEl.href, true, anchorEl);
    return false;
  }
  else if (anchorEl.classList.contains("ajax-load")){
    ajaxLoad(anchorEl.href, false, anchorEl);
    return false;
  }
  
  var href = anchorEl.getAttribute('href');
  var website = window.location.hostname;
  website = website.replace("www.", "");
  
  var internalLinkRegex = new RegExp(
    '^('
      +'(((http:\\/\\/|https:\\/\\/)(www\\.)?)?(' + website + '|(localhost.*)))' //starts with host
      +'|'  // or
      +'(localhost.*)' //starts with localhost
      +'|' // or
      +'((\\/|#|\\?|javascript:).*))'  //starts with / # ? javascript:
      +'((\\/|\\?|\#).*'  //ends with / # $
    +')?$'
    , '');
  
  var jsCheck = new RegExp('^(javascript:|\#|\\?).*?$');


  if (href) {
    if (!jsCheck.test(href) && !anchorEl.getAttribute('onclick')) {
      if (!internalLinkRegex.test(href)) {
        anchorEl.setAttribute('target', '_blank');
      }
      else if ( new URL(window.location.href, "http://example.com").pathname != new URL(href, "http://example.com").pathname) {
        return ajaxLoadHTML(anchorEl, ajaxReplacePage,  null);
      }
    }
  }
  return true;
}

var resizeTimer = 0;
function init() {
  if (!document.body.getAttribute("inited")) {
    document.body.setAttribute("orientation", getOrientation());
    if (detectmob()) {
      fixBgHeight();
    }
    if (!document.body.getAttribute("loaded-main") && document.body.className.match("blog")) {
      // if (!checkNeedRefresh()) {
      //   loadMain();
      // }
      //loadMainAlready = 1;
      document.body.setAttribute("loaded-main", true);
    }
    
    window.addEventListener('load', function (e) {
      hidePageLoading();
    });
    window.addEventListener('click', function(e) {
      if (e.metaKey || e.ctrlKey) {
        return;
      }

      const link = findLink(e.target);
      // console.log(link);
      if (link == null) {
        return;
      }
      else if (!handleLink(link)) {
        e.preventDefault();
        e.stopPropagation();
      }
    }, false);
    
    window.addEventListener("scroll", function (e) {
      handleScrollEvent(e);
    });
    if ('scrollRestoration' in history) {
      // history.scrollRestoration = 'manual';
    }
    window.addEventListener("popstate", function (e) {
      if (e.state) {
        // ajaxLoadHTML(this.window.location, ajaxReplacePage, {push: false, state: e.state});
        if (!popstateReplacePage(e.state)) {
          console.log("ready to ajax");
          ajaxLoadHTML(this.window.location, ajaxReplacePage, {push: false, state: e.state});
        }
      }
    });
    window.addEventListener("pagehide", pageHideCallBack);
    window.addEventListener("pageshow", pageShowCallBack);
    window.addEventListener("resize", function () {
      // console.log("resize");
      var ori_old = document.body.getAttribute("orientation");
      var ori = getOrientation();
      if (ori != ori_old) {
        document.body.setAttribute("orientation", ori);
      }
      drawButtonsShadow();
    });
    window.addEventListener('animationiteration', function(event) {
      if (event.target.classList.contains('loading-bar')) {
        if (document.body.classList.contains('page-loading-end')) {
          document.body.classList.remove('page-loading-end');
        }
      }
    });
    loadIndie();
    // document.body.setAttribute("page-loaded", true);
    const resizeObserver = new ResizeObserver(entries => {
      console.log('Body height changed:', entries[0].target.clientHeight);
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (document.body.getAttribute("page-loaded") == "true") {
          loadScrollPos(document.body.getAttribute("ajax-popstate") == "true");
          document.body.removeAttribute("page-loaded");
          document.body.removeAttribute("ajax-popstate");
        }
        saveScrollPos(document.body.getAttribute("url"));
      }, 100);
    });
    resizeObserver.observe(document.body);
    loadScrollPos();
  
    document.body.setAttribute("inited", true);

    //Obselete
    getStars();
    getStarsYear();
  }
  console.log("init");
}
function bodyInit() {
  darkModeInit();
  changeFontSizeInit();
  showPageLoading();
}

function pageShowCallBack (event, isAjax = false, isPopstate = false) {
  darkModeInit();
  changeFontSizeInit();
  // loadScrollPos();
  loadReadingProgress();
  saveLastUrl();

  // removeDuplicateWidgets();
	showPopupMessage();
	showTopMessage();
	initImg();
  // displayGoogleAds();

  if (isAjax) {
    handleScrollEvent();
    document.body.setAttribute("page-loaded", true);
    document.body.setAttribute("url", decodeURI(window.location.pathname));
    nodeScriptReplace(document.getElementById("page"));
  }
  if (isPopstate) {
    document.body.setAttribute("ajax-popstate", true);
  }
}

function pageHideCallBack (isAjax = true) {
    if (document.body.className.match("blog")) {
      saveMain();
    } 
    else {
      setFlag();
    }
}

function detectmob() {
  if (navigator.userAgent.match(/Android/i)
    || navigator.userAgent.match(/webOS/i)
    || navigator.userAgent.match(/iPhone/i)
    || navigator.userAgent.match(/iPad/i)
    || navigator.userAgent.match(/iPod/i)
    || navigator.userAgent.match(/BlackBerry/i)
    || navigator.userAgent.match(/Windows Phone/i)
  ) {
    return true;
  }
  else {
    return false;
  }
}

function isOverflown(element) {
  return element.scrollWidth > element.clientWidth;
}
function blurLeft(element) {
  element.setAttribute("style", "box-shadow: inset 10px 0px 5px -6px rgba(0,0,0,.5);");
}
function blurRight(element) {
  element.setAttribute("style", "box-shadow: inset -10px 0px 5px -6px rgba(0,0,0,.5);");
}
function blurLeftRight(element) {
  element.setAttribute("style", "box-shadow: inset 10px 0px 5px -6px rgba(0,0,0,.5), inset -10px 0px 5px -6px rgba(0,0,0,.5);");
}
function noBlur(element) {
  element.setAttribute("style", "box-shadow: none;");
}
function drawButtonsShadow() {
  overflown_obj = document.getElementById('label-container');
  blur_obj = document.getElementById('label-container-shadow');
  if (overflown_obj && blur_obj) {
    if (isOverflown(overflown_obj)) {
      var x = overflown_obj.scrollLeft;
      var ul = overflown_obj.scrollWidth - overflown_obj.clientWidth;
      if (x < 10)
        blurRight(blur_obj);
      else if (x >= ul - 10)
        blurLeft(blur_obj);
      else
        blurLeftRight(blur_obj);
    }
    else {
      noBlur(blur_obj);
    }
  }
}
function scrollToSelected() {
  var selected = document.getElementById("label-item selected");
  if (selected != null) {
    var topPos = selected.offsetLeft;
    // document.getElementById('label-container').scrollLeft = topPos-10;
    document.getElementById("label-container").scrollTo({
      left: topPos - 10,
      behavior: "smooth"
    });
  }
  drawButtonsShadow();
}

function setResizeListener() {
  
}
function getOrientation() {
  var width = window.innerWidth || document.documentElement.clientWidth;
  var height = window.innerHeight || document.documentElement.clientHeight;
  var local_orientation = width > height ? "landscape" : "portrait";
  
  return local_orientation;
}
function  fixBgHeight() {
  var height = window.innerHeight || document.documentElement.clientHeight;
  var width =  window.innerWidth || document.documentElement.clientWidth;
  if (height > 500) {
    var bg_div = document.getElementById("bg-div");
    if (window.matchMedia('(max-aspect-ratio: 1920/1200) and (min-height: 501px)').matches) {
      // var sat = parseInt(getComputedStyle(document.documentElement).getPropertyValue("--sat").replace("px", ""));
      var sat = 0;
      // var bg_fixed_h = height + sat + 100;
      var bg_fixed_h = height + sat + (height / width * 80);
      // console.log("fixed_h: "+bg_fixed_h);
      bg_div.style.backgroundSize = "auto " + bg_fixed_h + "px";
    }
    else {
      bg_div.style.backgroundSize = "cover";
    }
  }
}

function detectHeader() {
  var main_height = document.getElementById("main").scrollTop;
  var current = document.body.scrollTop || document.scrollingElement.scrollTop;

  if (current > main_height) {
    if (!document.body.className.match("collapsed-header")) {
      document.body.classList.add("collapsed-header");
    }
  } else {
    if (document.body.className.match("collapsed-header")) {
      document.body.classList.remove("collapsed-header");
    }
  }
}

function removeAllButLast(query) {
  var ele_array = document.querySelectorAll(query);
  for (i = 0; i < ele_array.length - 1; i++) {
    ele_array[i].parentNode.removeChild(ele_array[i]);
  }
}

function ajaxLoad(link, removeFirst = false, button = null) {
  if (!button) {
    button = link;
  }
  ajaxLoadHTML(button, ($args) => {
    const ajax_html = $args.responseText;
    var ajax_doc = new DOMParser().parseFromString(ajax_html, "text/html");
    var ajax_main = ajax_doc.getElementById("main");
    if (ajax_main) {
        var ajax_articles = ajax_main.getElementsByTagName("article");
        if (removeFirst) {
          if (ajax_articles.length > 1) {
            ajax_articles[0].parentNode.removeChild(ajax_articles[0]);
          }
          else if (ajax_articles.length == 1) {
              var next_link = ajax_doc.getElementById('blog-pager-older-link');
              ajaxLoad(next_link.href);
              return;
          }
        }
        var main = document.getElementById("main");
        main.insertAdjacentHTML('beforeend', ajax_main.innerHTML);

        removeAllButLast('[id*=blog-pager-older-link]');
        removeAllButLast('[id=blog-pager]');

        // history.replaceState({main: main.innerHTML}, document.title, window.location);
        history.replaceState({page: document.getElementById("page").innerHTML}, document.title, window.location);
        // saveScrollPos();
        loadReadingProgress();
        hidePageLoading();
    }
  }, null, true);
}
function ajaxLoadOld(link, removeFirst = false, button = null) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if ((this.readyState == 4 && this.status == 200) || (this.readyState == 4 && this.status == 404)) {
      console.log("200");
      var ajax_html = this.responseText;
      if (ajax_html.indexOf("</html>") == -1) {
        console.log('-1');
        return;
      }
      
      var ajax_doc = new DOMParser().parseFromString(ajax_html, "text/html");
      var ajax_main = ajax_doc.getElementById("main");
      if (ajax_main) {
          var ajax_articles = ajax_main.getElementsByTagName("article");
          if (removeFirst) {
            if (ajax_articles.length > 1) {
              ajax_articles[0].parentNode.removeChild(ajax_articles[0]);
            }
            else if (ajax_articles.length == 1) {
                var next_link = ajax_doc.getElementById('blog-pager-older-link');
                ajaxLoad(next_link.href);
                return;
            }
          }
          var main = document.getElementById("main");
          main.insertAdjacentHTML('beforeend', ajax_main.innerHTML);
          // main.innerHTML = main.innerHTML + ajax_main.innerHTML;

          removeAllButLast('[id*=blog-pager-older-link]');
          removeAllButLast('[id=blog-pager]');
          clearTimeout(timer);    
      }
      hidePageLoading();
      loadReadingProgress();
    }
  };
  if (link) {
    var tempMoreMsg = "更多文章";

    showPageLoading();
    if (button) {
      tempMoreMsg = button.innerHTML;
      button.innerHTML = "載入中…";
      button.style["pointer-events"] = "none";
    }

    var real_link = link;
    xhttp.open("GET", real_link, true);
    xhttp.send();

    setTimeout(function () {
      timer = setTimeout(function () {
        if (button) {
          button.innerHTML = tempMoreMsg;
          button.style["pointer-events"] = "all";
        }
        hidePageLoading(0);
        xhttp.abort();
      }, 5000);
    }, 1000);
  }
}

function ajaxLoadHTML(link, ajaxCallback = null, ajaxCallBackArgs = null, appendMode = false) {
  var anchorEl = null;
  if (link.nodeType) {
    anchorEl = link;
    link = link.href;
  }
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && (this.status == 200 || this.status == 404)) {
      console.log("ajaxLoadHTML: " + link + " success.");
      if (anchorEl) {
        anchorEl.classList.remove("disabled");
      }
      clearTimeout(timer); 
      if (ajaxCallback) {
        var args = {
          responseText: this.responseText,
          link: link,
          push: ajaxCallBackArgs ? (ajaxCallBackArgs.push ? ajaxCallBackArgs.push : false) : true,
          state: ajaxCallBackArgs ? (ajaxCallBackArgs.state ? ajaxCallBackArgs.state : null) : null
        };
        ajaxCallback(args);
      }
      // hidePageLoading();
      // loadReadingProgress();
    }
  };
  if (link) {
    if (anchorEl) {
      anchorEl.classList.add("disabled");
    }
    xhttp.open("GET", link, true);
    xhttp.send();
    showPageLoading(!appendMode);
    timer = setTimeout(function () {
      hidePageLoading(0);
      xhttp.abort();
      if (anchorEl) {
        anchorEl.classList.remove("disabled");
      }
    }, 5000);

  }

  return false;
}

function ajaxReplacePage(args = null) {
  const responseText = args.responseText;
  const link = args.link;
  const push = args.push;
  const state = args.state;
  
  var ajax_doc = new DOMParser().parseFromString(responseText, "text/html");
  // document.body.classList.add("page-loading", "ajax-loading");
  ajax_doc.body.classList.add("page-loading", "ajax-loading");
  var ajax_page = ajax_doc.getElementById("page");
  var body_page = document.getElementById("page");
  
  // handleScrollEvent();
  pageHideCallBack();
  if (push) {
    // history.replaceState(document.body.classList.contains("blog") ? {page: body_page.innerHTML, classList: document.body.classList.value} : {}, document.title, window.location);
    history.replaceState({page: body_page.innerHTML, classList: document.body.classList.value}, document.title, window.location);
    history.pushState({page: ajax_page.innerHTML, classList: ajax_doc.body.classList.value}, ajax_doc.title, link);
  }
  else {
    document.body.setAttribute("ajax-popstate", true);
  }
  window.scrollTo(0, 0);
  document.body.classList = ajax_doc.body.classList;
  // document.body.replaceChild(ajax_page ,body_page);
  body_page.innerHTML = ajax_page.innerHTML;
  // document.title = ajax_doc.title;
  // if (state && state.main) {
  //   document.getElementById("main").innerHTML = state.main;
  // }
  hidePageLoading();
  pageShowCallBack(null, true);
}

function popstateReplacePage(state) {
  if (state && state.page && state.classList) {
    showPageLoading(true);
    document.getElementById("page").innerHTML = state.page;
    document.body.classList = state.classList;//.replace("page-loading", "").replace("ajax-loading","");
    pageShowCallBack(null, true, true);
    hidePageLoading();
    console.log("replacepage");
    return true;
  }
  return false;
}

function nodeScriptReplace(node) {
  if ( nodeScriptIs(node) === true ) {
          node.parentNode.replaceChild( nodeScriptClone(node) , node );
  }
  else {
          var i = -1, children = node.childNodes;
          while ( ++i < children.length ) {
                nodeScriptReplace( children[i] );
          }
  }

  return node;
}
function nodeScriptClone(node){
  var script  = document.createElement("script");
  script.text = node.innerHTML;

  var i = -1, attrs = node.attributes, attr;
  while ( ++i < attrs.length ) {                                    
        script.setAttribute( (attr = attrs[i]).name, attr.value );
  }
  return script;
}

function nodeScriptIs(node) {
  return node.tagName === 'SCRIPT';
}

function displayGoogleAds(){
  var ins = document.querySelectorAll("ins");
  // for (var ad in ins) {
  for (var i = 0; i < ins.length; i++) {
    (adsbygoogle = window.adsbygoogle || []).push({});
  }
}

function convertDateTime(dateTime) {
  // const dateTime = '2017-02-04 11:23:54';
  if (dateTime) {
    let dateTimeParts= dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
    dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
    
    return new Date(...dateTimeParts); // our Date object
  }

  return new Date();
}

function checkNeedRefresh() {
  if (typeof (Storage) == undefined || document.body.classList.contains("error404")) {
    return true;
  }
  var last_update = sessionStorage.getItem("last-update");
  if (last_update != null) {
    // var d1 = new Date(document.lastModified);
    var d1 = convertDateTime(document.body.getAttribute("last-update"));
    var d2 = convertDateTime(last_update);
    var url1 = sessionStorage.getItem("last-list-url");
    var url2 = window.location.href;
    // console.log("d1: " + d1 +"d2: " + d2);
    // console.log("last-list-url: " + sessionStorage.getItem("last-list-url"));

    if ((d1.getTime() == d2.getTime()) && (url1 == url2)) {
      return false;
    }
  }
  return true;
}

function saveMain(str) {
  if (typeof (Storage) !== "undefined") {
    if (!str) {
      var main = document.getElementById("main");
      str = main.innerHTML;
    }
    sessionStorage.clear();
    sessionStorage.setItem("main", str);
    sessionStorage.setItem("last-update", document.body.getAttribute("last-update"));

    if (!document.body.className.match("item-view"))
      sessionStorage.setItem("scrollPos", document.body.scrollTop || document.scrollingElement.scrollTop);
  }
  return "unload!";
}

function saveLastUrl() {
  // document.body.setAttribute("last-url", window.location);
  if (typeof (Storage) !== "undefined") {
    sessionStorage.setItem("last-url", window.location);
    // console.log("last url: " + sessionStorage.getItem("last-url"));
    if (!document.body.classList.contains("item-view")) {
      sessionStorage.setItem("last-list-url", window.location);
    }
  }
}

function loadMain() {
  console.log("loadedmain");
  if (typeof (Storage) !== "undefined") {
    // if (sessionStorage.getItem("inPost") != null) {
      
      if (sessionStorage.getItem("main") != null){// && sessionStorage.getItem("inPost") != null) {
        var main = document.getElementById("main");
        main.innerHTML = sessionStorage.getItem("main");
        
        //set scrollPos
        if (sessionStorage.getItem("scrollPos") != null) {
          var scrollPos = sessionStorage.getItem("scrollPos") ? sessionStorage.getItem("scrollPos") : 0;
          setTimeout(function () {
            window.scrollTo(0, scrollPos);
          }, 1000);
        }
        loadScrollPos();
      }
      sessionStorage.clear();
    // }
  }
}
function setFlag() {
  if (typeof (Storage) !== "undefined") {
    sessionStorage.setItem("inPost", "true");
  }
}

function getCookie(cname) {
  var name = cname + '=';
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function changeFontSizeInit() {
  if (document.body.className.match("item-view")) {
    var font_size_cookie = getCookie("font-size");
    if (font_size_cookie == "") {
      font_size_cookie = getCookie("font_size");
    }
    if (font_size_cookie != "") {
      var body = document.body;
      body.classList.remove("f12px", "f13px", "f14px", "f15px", "f16px", "f17px", "f18px");
      //body.classList.remove("font-xs", "font-s", "font-m", "font-l", "font-xl");

      body.classList.add(font_size_cookie);
      writeCookie("font-size", font_size_cookie);
    }
  }
}
function changeFontSize() {
  var body = document.body;
  var next_font_size = "f15px";
  
  if (body.classList.contains("f12px") || body.classList.contains("f13px")) {
    next_font_size = "f14px";
  }
  else if (body.classList.contains("f14px")) {
    next_font_size = "f15px";
  }
  else if (body.classList.contains("f15px")) {
    next_font_size = "f16px";
  }
  else if (body.classList.contains("f16px")) {
    next_font_size = "f17px";
  }
  else if (body.classList.contains("f17px") || body.classList.contains("f18px")) {
    next_font_size = "f13px";
  }
  body.classList.remove("f12px", "f13px", "f14px", "f15px", "f16px", "f17px", "f18px");
  body.classList.add(next_font_size);
  setCookieFontSize(next_font_size);
}
function setCookieFontSize(px) {
  writeCookie("font-size", px);
}


function getStars() {
  var star = getCookie("star_today");
  if (star == "") {
    star = Math.floor(Math.random() * 10) + 1;
    var someDate = new Date();
    //var timeZone = -(someDate.getTimezoneOffset() / 60);
    someDate.setHours(0, 0, 0);
    someDate.setDate(someDate.getDate() + 1);
    var cookie = "star_today=" + star + "; expires=" + someDate.toUTCString() + "; path=/; samesite=lax";
    document.cookie = (cookie);
  }
  var str = '';
  var starCount = star;
  for (i = 0; i < 10; i++) {
    if (starCount > 0) {
      str += '★　';
      starCount--;
    }
    else {
      str += '☆　';
    }
  }

  var starDiv = document.getElementById('stars');
  if (starDiv) {
    starDiv.innerHTML = str;
  }
}

function setStarsYear(star) {
  var d = new Date();
  var year = d.getFullYear();
  var someDate = new Date(year + 1, 0, 1, 0, 0, 0, 0);
  var cookie = "star-year=" + star + "; expires=" + someDate.toUTCString() + "; path=/; samesite=lax";
  document.cookie = (cookie);
}

function getStarsYear() {
  var star2020 = getCookie("star-2020");
  if (star2020 != "") {
    setStarsYear(star2020);
  }
  var star = getCookie("star-year");
  if (star == "") {
    star = Math.floor(Math.random() * 10) + 1;
    setStarsYear(star);
  }
  var str = '';
  var starCount = star;
  for (i = 0; i < 10; i++) {
    if (starCount > 0) {
      str += '★　';
      starCount--;
    }
    else {
      str += '☆　';
    }
  }

  var starDiv = document.getElementById('star-year');
  if (!starDiv) {
    starDiv = document.getElementById('star-2020');
  }
  if (starDiv) {
    starDiv.innerHTML = str;
  }

  var retryTimes = getCookie('star-year-retry');
  if (retryTimes > 0) {
    var str = '平行時空：' + retryTimes;
    var starRetryDiv = document.getElementById('star-year-retry');
    if (starRetryDiv) {
      starRetryDiv.innerHTML = str;
    }
  }
}

function retryStarsYear() {
  clearCookie('star-2020');
  clearCookie('star-year');
  var retryTimes = getCookie('star-year-retry');
  if (retryTimes == '') {
    retryTimes = 0;
  }
  retryTimes++;
  var d = new Date();
  var year = d.getFullYear();
  var someDate = new Date(year + 1, 0, 1, 0, 0, 0, 0);
  var cookie = "star-year-retry=" + retryTimes + "; expires=" + someDate.toUTCString() + "; path=/; samesite=lax";
  document.cookie = (cookie);

  getStarsYear();
}

function clearCookie(cookie_key) {
  var someDate = new Date(0);
  var cookie = cookie_key + "=" + 0 + "; expires=" + someDate.toUTCString() + "; path=/; samesite=lax";
  document.cookie = (cookie);
}

function writeCookie(key, value, days=30) {
  var someDate = new Date();
  someDate.setDate(someDate.getDate() + days);
  someDate.setHours(0,0,0,0);

  var cookie = key + "=" + value + "; expires=" + someDate.toUTCString() + "; path=/; samesite=lax";  
  document.cookie = (cookie);
}

function darkMode() {
  var body = document.body;
  var darkOverlay = document.getElementById("dark_mode_overlay");
  if (!darkOverlay) {
    darkOverlay = document.getElementById("dark-mode-overlay");
  }

  if (!body.classList.contains("dark-mode")) {
    body.classList.add("dark-mode");
    writeCookie("dark-mode", 1);
  }
  else {
    body.classList.remove("dark-mode");
    clearCookie("dark-mode");
  }
}
function darkModeInit() {
  var body = document.body;
  var cookie_value = getCookie("dark-mode");
  var someDate = new Date();
  var numberOfDaysToAdd = 30;
  someDate.setDate(someDate.getDate() + numberOfDaysToAdd);

  if (cookie_value != "") {
    if (cookie_value == "1") {
      body.classList.add("dark-mode");
      writeCookie("dark-mode", 1);
    }
  }
  else {
    body.classList.remove("dark-mode");
    clearCookie("dark-mode");
  }
}


// ScrollPos
function getScrollPercent(bottomPadding = 580) {
  var h = document.documentElement, 
      b = document.body,
      st = 'scrollTop',
      sh = 'scrollHeight';
  // console.log("scrollHeight: " + (h[st]||b[st]));
  var percent = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight - (document.body.classList.contains("is-post") ? bottomPadding : 0)) * 100;
  // console.log("scrollPercent: " + percent);
  
  return Math.min(100, (Math.round(percent * 100) / 100));
}

function getLocalStorageScrollPos(key = "scrollPosJsonURIDecode") {
  if (typeof (Storage) !== "undefined") {
      // var scrollPosJson = localStorage.getItem("scrollPosJson");
      var scrollPosJson = localStorage.getItem(key);
      var scrollPosObj = scrollPosJson ? JSON.parse(scrollPosJson) : {};

      return scrollPosObj;
  }
}

function saveScrollPos(path = undefined, scrollPercent = undefined) {
  if (!document.body.classList.contains("error404")) {
    if (typeof (Storage) !== "undefined") {
      var scrollPosObj = getLocalStorageScrollPos();
      if (!path) {
        path = decodeURI(window.location.pathname);
      }
      else {
        path = decodeURI(path);
      }
      if (scrollPercent === undefined) {
        // scrollPercent = (document.body.getAttribute("scrollPos") != undefined) ? document.body.getAttribute("scrollPos") : 0;
        scrollPercent = getScrollPercent();
      }
      console.log(path + ": " + scrollPercent);
      scrollPosObj[path] =  scrollPercent;
      // localStorage.setItem("scrollPosJson", JSON.stringify(scrollPosObj));
      localStorage.setItem("scrollPosJsonURIDecode", JSON.stringify(scrollPosObj));
    }
  }
}

function convertScrollPosJson() {
  if (typeof(Storage !== null) &&  localStorage.getItem("scrollPosJson")) {
    const json = getLocalStorageScrollPos("scrollPosJson");
    for (var key in json) {
      // console.log(key + " " + json[key]);
      saveScrollPos(key, json[key]);
    }
    localStorage.removeItem("scrollPosJson");
  }
}

function loadScrollPos(popstate = false, bottomPadding = 580) {
// get scrollPos
  if (window.location.hash) {
    const anchor = document.querySelector("[id='" + window.location.hash.replace("#", "") + "'], [name='" + window.location.hash.replace("#", "") + "']");
    // location.hash = "#" + location.hash;
    console.log("anchor: " + anchor);
    if (anchor) {
      window.scrollTo({
        top: anchor.getBoundingClientRect().top + window.pageYOffset, // scroll so that the element is at the top of the view
        behavior: 'smooth' // smooth scroll
      })
    }
  }

  if (popstate || document.body.classList.contains("is-post")) {
    if (typeof (Storage) == "undefined") {
      return;
    }

    var scrollPosObj = getLocalStorageScrollPos();
    var scrollPos = scrollPosObj ? scrollPosObj[decodeURI(window.location.pathname)] : 0;
    // console.log(scrollPos);
    updateItemViewProgressBar(scrollPos);
    if (scrollPos != undefined) {
      scrollPos = scrollPos / 100;
      if (document.body.classList.contains("is-post")) {
        if (scrollPos < 0.05 || scrollPos > 0.99 || (document.documentElement.clientHeight > ((document.documentElement.scrollHeight || document.body.scrollHeight) - bottomPadding))) {
          return;
        }
      }
      setTimeout(function (){
        var scrollPosFromPercent = scrollPos * (document.documentElement.scrollHeight - document.documentElement.clientHeight - (document.body.classList.contains("is-post") ? bottomPadding : 0));
        // window.scrollTo(0, scrollPosFromPercent);
        window.scrollTo({
          top: scrollPosFromPercent,
          behavior: popstate ? "auto" : "smooth"
        });
      }, popstate ? 0 : 0);
    }
    
  }
}
function loadReadingProgress() {
  if (!document.body.classList.contains("is-post")) {
    var scrollPosObj = getLocalStorageScrollPos();
    var articles = document.getElementsByTagName("article");
    //console.log(articles);
    for (var i = 0; i<articles.length; i++) {
      
      var progressBars = articles[i].getElementsByClassName("progress-bar");
      var postTitleAs =  articles[i].getElementsByClassName("post-title-a");
      //console.log(progressBars);
      //console.log(postTitleAs);
      if (progressBars.length > 0 && postTitleAs.length > 0){
        var url = new URL(postTitleAs[0].href);
        var percent = scrollPosObj[decodeURI(url.pathname)];
        if (!percent) {
          scrollPosObj[url.pathname];
        }
        if (percent != undefined) {
          var percentF = parseFloat(percent);
          progressBars[0].classList.add("visited");
          progressBars[0].setAttribute("style", "width: " + (percentF) + "%");
        }
        else {
          progressBars[0].classList.remove("visited");
        }
      }
    }
  }
}
var scrollTimer = 0;
function handleScrollEvent(e) {
  // if (document.body.classList.contains("is-post")) {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function (){
      var scrollPercent = getScrollPercent();
      // console.log(document.body.classList.contains("collapsed-header") && (scrollPercent > 1) ) ;
    if (!document.body.classList.contains("page-loading")) {
      if (document.body.classList.contains("blog")  || (document.body.classList.contains("is-post") && document.body.classList.contains("collapsed-header") && (scrollPercent > 1)) ) {
        document.body.setAttribute("scrollPos", scrollPercent);
        saveScrollPos();
        updateItemViewProgressBar();
      }
    }
  }, 500);
  // }
  
  var article = document.querySelector(".post-outer");
  if (article) {
    if(article.getBoundingClientRect().top < 0 && !document.body.classList.contains("collapsed-header")){
      document.body.classList.add("collapsed-header");
    }
    else if (article.getBoundingClientRect().top > 0 && document.body.classList.contains("collapsed-header")) {
      document.body.classList.remove("collapsed-header");
    }
  }

}
function updateItemViewProgressBar(progress = false) {
  if (document.body.classList.contains("is-post")) {
    var progressBar = document.getElementById("progress-bar-top-bar");
    if (progressBar) {
      progressBar.setAttribute("style", "width: " +  (progress ? progress : getScrollPercent()) + "%");
      progressBar.classList.add("visited");
    }
    else {
      //alert('null');
    }

    if (progress) {
      document.body.setAttribute("scrollPos", progress);
    }
  }
}