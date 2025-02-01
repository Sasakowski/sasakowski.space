<?php \Internals\HTML\Head(); \Internals\HTML\UseJS(); \Internals\HTML\Top(); ?>

<block><flex_rows>

	<block2 class = "center_h"><text_l>Stylization Guide</text_l></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">1 - How to HTML</text_l>
		<space></space>
		<block3><flex_rows>
			<text>The raw contents of an HTML document is also referred to as its <i>markup</i>. If you know what <i>Markdown</i> is, know that Markdown is really just HTML at its core:</text>
			<space_s></space_s>
			<text><?php echo \Internals\XSS\LGT("*Markdown italic*&emsp;<i>HTML italic</i>&emsp;**Markdown bold**&emsp;<b>HTML bold</b>&emsp;***Markdown bold + italic***&emsp;<b><i>HTML bold + italic</i></b>"); ?></text>
			<space></space>
			<text>Most user-based inputs on this website have some stylization options at their disposal. Markdown isn't implemented, so it won't work.</text>
			<space></space>
			<text>HTML itself defines a set of elements, <i>i</i> and <i>b</i> being two prime examples, that have predefined stylization data. However, this website also <a href = "https://sasakowski.space/Static/Stylesheets/Master.css">defines its own elements</a>.</text>
		</flex_rows></block3>
		
		<space_l></space_l>
		
		<block3><flex_rows>
			<text>A major fuctionality of HTML is the attribute. Attributes modify the stylization/metadata of elements. There are many predefined attributes to pick from, and this website defines its own attributes as well.</text>
			<space></space>
			<text>Attributes are given to elements like this:</text>
			<space_s></space_s>
			<text><?php echo \Internals\XSS\LGT("<something&emsp;key1=value1&emsp;key2=\"value2\"&emsp;key3&emsp;key4=value4&emsp;and so on> [...] </something>"); ?></text>
			<space></space>
			<text>A more practical example:</text>
			<space_s></space_s>
			<text><?php echo \Internals\XSS\LGT("<a&emsp;href=\"www.google.com\"> (this will be a link and will lead to the search engine if clicked) </a>"); ?></text>
			<space></space>
			<text><i>id</i> and <i>class</i> are used to stylize/modify elements selectively:</text>
			<space_s></space_s>
			<text><?php echo \Internals\XSS\LGT("<div&emsp;class=\"class1 class2 class3\"&emsp;id=\"id1\"> (IDs must be unique, but classes don't) </div>"); ?></text>
		</flex_rows></block3>

		<space_l></space_l>

		<block3><flex_rows>
			<text>Note that ALL user-given inputs on this website are checked for anything 'disallowed', such as HTML-markup-where-not-supposed-to. Due to how HTML works, the &lt; and &gt; characters cannot be used as-is.</text>
			<space></space>
			<text>If their usage is still required:</text>
			<space_s></space_s>
			<text>&amp;lt; for the &lt;&emsp;&emsp;&amp;gt; for the &gt;</text>
		</flex_rows></block3>

		<space_l></space_l>

		<block3><flex_rows>
			<text>Because this is an undersized crashcourse, seeking out other places to learn the basics of HTML is <i>highly</i> recommended.</text>
			<space_s></space_s>
			<text>After that, <i>inspect the pages</i> of this website to see how the elements <text_s>(especially the custom ones)</text_s> work around here.</text>
		</flex_rows></block3>

	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">2 - Dictionarium hyperscripti</text_l>
		<space></space>

		<block3><flex_rows>
			<text_l>Defined by HTML:</text_l>
			<space></space>
			<text>&lt;i&gt; <i>Italic text</i></text>
			<space_s></space_s>
			<text>&lt;b&gt; <b>Bold text</b></text>
			<space_s></space_s>
			<text>&lt;a&gt; <a>Leads to another page when clicked (hyperlinks)</a>&emsp;href="[...]" target URL&emsp;target="_blank" open a new window instead</text>
		</flex_rows></block3>

		<space_l></space_l>

		<block3><flex_rows>
			<text_l>Defined by <i>https://sasakowski.space:</i></text_l>
			<space></space>
			<text>&lt;flex_columns&gt; All elements inside are structured horizontally</text>
			<space_s></space_s>
			<text>&lt;flex_rows&gt; All elements inside are structured vertically</text>
			<space></space>
			<text>&lt;block&gt; Container for other elements</text>
			<space_s></space_s>
			<text>&lt;block2&gt; Container for other elements</text>
			<space_s></space_s>
			<text>&lt;block3&gt; Container for other elements</text>
			<space></space>
			<text>class="center_h" center items horizontally</text>
			<space_s></space_s>
			<text>class="center_v" center items vertically</text>
			<space></space>
			<text>&lt;quote&gt; <quote>Fancy quotation marks</quote></text>
			<space></space>
			<text>&lt;text_s&gt; <text_s>Scale text</text_s></text>
			<space_s></space_s>
			<text>&lt;text&gt; <text>Scale text</text></text>
			<space_s></space_s>
			<text>&lt;text_l&gt; <text_l>Scale text</text_l></text>
			<space_s></space_s>
			<text>&lt;text_xl&gt; <text_xl>Scale text</text_xl></text>
			<space_s></space_s>
			<text>&lt;text_xxl&gt; <text_xxl>Scale text</text_xxl></text>
			<space></space>
			<flex_columns><text>&lt;space_s&gt; Space in between elements: A</text><space_s></space_s><text>B</text></flex_columns>
			<space_s></space_s>
			<flex_columns><text>&lt;space&gt; Space in between elements: A</text><space></space><text>B</text></flex_columns>
			<space_s></space_s>
			<flex_columns><text>&lt;space_l&gt; Space in between elements: A</text><space_l></space_l><text>B</text></flex_columns>
			<space_s></space_s>
			<flex_columns><text>&lt;space_xl&gt; Space in between elements: A</text><space_xl></space_xl><text>B</text></flex_columns>
			<space_s></space_s>
			<flex_columns><text>&lt;space_xxl&gt; Space in between elements: A</text><space_xxl></space_xxl><text>B</text></flex_columns>
			<space></space>
			<text>class="COLLAPSIBLE"<text_s>(JS only)</text_s> Create collapsible <text_s>flex_columns or flex_rows only, and first element inside it should have class="HEADER"</text_s></text>
			<space_s></space_s>
			<text>class="HEADER"<text_s>(JS only)</text_s> Make element be title of a collapsible <text_s>parent element should have class="COLLAPSIBLE"</text_s></text>

		</flex_rows></block3>

	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">3a - Forum comments</text_l>
		<space></space>
		<block3><flex_rows>
			<text>&lt;i&gt;</text>
			<space_s></space_s>
			<text>&lt;b&gt;</text>
			<space_s></space_s>
			<text>&lt;text_l&gt;</text>
			<space_s></space_s>
			<text>&lt;text_s&gt;</text>
		</flex_rows></block3>
	</flex_rows></block2>

	<space_xl></space_xl>

	<block2><flex_rows class = "COLLAPSIBLE">
		<text_l class = "HEADER">3b - Profiles</text_l>
		<space></space>
		<block3><flex_rows>
			<text>&lt;flex_columns&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;flex_rows&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;block&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;block2&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;block3&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;text_s&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;text&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;text_l&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;text_xl&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;text_xxl&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;a&gt;&emsp;style=""&emsp;target=""&emsp;href=""</text>
			<space_s></space_s>
			<text>&lt;quote&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;b&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;i&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;style&gt;&emsp;class=""&emsp;src=""</text>
			<space_s></space_s>
			<text>&lt;div&gt;&emsp;class=""&emsp;style=""</text>
			<space_s></space_s>
			<text>&lt;img&gt;&emsp;class=""&emsp;style=""&emsp;src=""</text>
		</flex_rows></block3>
	</flex_rows></block2>


</flex_rows></block>