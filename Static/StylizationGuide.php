<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<block><flex_rows>

	<block2 class = "center_h">
		<text>Please only refer to the section you've come from. Using any other stylizations will generally not work.
		</text>
	</block2>

	<space_l></space_l>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">How to stylize <text>using raw HTML</text></text_l>
		
		<space></space>
		
		<block3><text>User-defined content is usually given access to a varying range of raw HTML stylizations, meaning that to <i>stylize</i> <b>text</b>, <b><i>they must use HTML code</i></b>. Markdown isn't enabled or implemented on this website.
		If you've used markdown (md) *<i>to make stuff italic</i>*, **<b>or make stuff bold</b>**, or *<i>or to make **<b>stuff</b>** both</i>*, you also know how to use HTML. The only real downside is that HTML is more time-consuming to type and less intuitive, but much more powerful in the long run.

		To stylize something, it's encapsulated around some special characters.
		In markdown, to make some text italic, it's *<i>encapsulated by asteriks, one on each side</i>*. The HTML-equivalent &lt;i&gt;<i>to italic looks like this</i>&lt;/i&gt;.
		The thing without the slash opens a stylization, and the one with the slash closes it. These things are called elements.

		On this website, giving specific elements specific attributes will change their appearance or functionality.
		</text></block3>
		
		<space_l></space_l>
		
		<block3><text><text_l>Attributes</text_l>
			An element can have attributes, which are often given values respectively.
			
			For example:
			The &lt;a&gt; turns stuff into links. The 'href' attribute determines the destination of the link element.
			&lt;a href = "https://www.google.com"&gt;<text_s>This element will look like a link and will lead to Google upon being clicked.</text_s>&lt;/a&gt;

			An element can have multiple attributes:
			&lt;a href = "https://www.google.com" target = "_blank"&gt;<text_s>This link will open a new window instead of changing this one.</text_s>&lt;/a&gt;
		</text></block3>

		<space_l></space_l>

		<block3><text><text_l>IDs and classes</text_l>
		<text>Besides attributes, an element can also have an ID and classes assigned to it. Note: IDs and classes are also attributes.
		
		An ID must be unique within an entire HTML document. It's recommended to do a 'view source' (view a page's raw HTML) first, because IDs cannot be shared in between elements.
		&lt;div id = "some_unique_ID"&gt;&lt;/div&gt;

		Classes can be assigned to multiple elements. An element can have more than one class assigned to it.
		&lt;div class = "class1 class2 class3 class4 ..."&gt;&lt;/div&gt;
		</text></block3>

		<space_l></space_l>

		<block3><text><text_l>Less than, greater than</text_l>
		In the rare occasion that you want to type the '<' and '>' characters without them causing HTML to activate, type the following:
		<&emsp;->&emsp;&amp;lt;
		>&emsp;->&emsp;&amp;gt;
		</text></block3>
	</flex_rows></block2>

	<space_l></space_l>



	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">Forum</text_l>
		<space></space>
		<text>&lt;i&gt;&ensp;<i>italic</i>&ensp;&lt;/i&gt;</text>
		<space_l></space_l>
		<text>&lt;b&gt;&ensp;<b>bold</b>&ensp;&lt;/b&gt;</text>
		<space_l></space_l>
		<text>&lt;text_l&gt;&ensp;<text_l>larger</text_l>&ensp;&lt;/text_l&gt;</text>
		<space_l></space_l>
		<text>&lt;text_s&gt;&ensp;<text_s>smaller</text_s>&ensp;&lt;/text_s&gt;</text>
		<space_l></space_l>
		<text>Line breaks are considered.</text>
		</text>
	</flex_rows></block2>


</flex_rows></block>