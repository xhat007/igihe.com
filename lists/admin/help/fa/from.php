برای تنظیم خطِ از میتوانید از سه روش گوناگون استفاده کنید:
<ul>
<li>یک کلمه: این کلمه به صورت &lt;کلمه&gt;@<?php echo $domain?> قالب بندی می‌شود.
<br>مانند: <b>information</b> می‌شود <b>information@<?php echo $domain?></b>
<br>در بیشتر برنامه‌های ایمیل این به صورت نشانی <b>information@<?php echo $domain?></b>
<li>دو کلمه یا بیشتر: به صورت <i>کلماتی که تایپ میکنید</i> &lt;listmaster@<?php echo $domain?>&gt;
<br>مانند: <b>اطلاعات فهرست</b> می‌شود <b>اطلاعات فهرست &lt;listmaster@<?php echo $domain?>&gt; </b>
<br>در بیشتر برنامه‌ها این به صورت دریافت شده از  <b>اطاعات فهرست</b>
<li>صفر کلمه یا بیشتر به همراه نشانی ایمیل: این به صورت <i>کلمه ها</i> &lt;emailaddress&gt;
<br>مانند: <b>نام من my@email.com</b> می‌شود <b>نام من &lt;my@email.com&gt;</b>
<br>در بیشترِ برنامه‌های ایمیل این به صورت <b>نام من</b> نمایش داده میشود.