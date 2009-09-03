{config_load file=images.conf section="attendance"}
{strip}
{if $currentStatus == 1}
	{#images_s_unknown#}
{elseif $lock == 1}
	{#images_a_unknown#}
{else}
	<a href="#void" onClick='$("#attendance_{$attendance}").load("index.php?page=attendanceBlock&key={php}echo secureform_add_pk('attendanceBlock', 60, $this->get_template_vars('attendance')){/php}&attendance={$attendance}&status=1");'>
		{#images_a_unknown#}
	</a>
{/if}


{if $currentStatus == 2}
	{#images_s_present#}
{elseif $lock == 1}
	{#images_a_present#}
{else}
	<a href="#void" onClick='$("#attendance_{$attendance}").load("index.php?page=attendanceBlock&key={php}echo secureform_add_pk('attendanceBlock', 60, $this->get_template_vars('attendance')){/php}&attendance={$attendance}&status=2");'>
		{#images_a_present#}
	</a>
{/if}


{if $currentStatus == 3}
	{#images_s_absent#}
{elseif $lock == 1}
	{#images_a_absent#}
{else}
	<a href="#void" onClick='$("#attendance_{$attendance}").load("index.php?page=attendanceBlock&key={php}echo secureform_add_pk('attendanceBlock', 60, $this->get_template_vars('attendance')){/php}&attendance={$attendance}&status=3");'>
		{#images_a_absent#}
	</a>
{/if}


{if $currentStatus == 4}
	{#images_s_excused#}
{elseif $lock == 1}
	{#images_a_excused#}
{else}
	<a href="#void" onClick='$("#attendance_{$attendance}").load("index.php?page=attendanceBlock&key={php}echo secureform_add_pk('attendanceBlock', 60, $this->get_template_vars('attendance')){/php}&attendance={$attendance}&status=4");'>
		{#images_a_excused#}
	</a>
{/if}


{if $currentStatus == 5}
	{#images_s_coop#}
{elseif $lock == 1}
	{#images_a_coop#}
{else}
	<a href="#void" onClick='$("#attendance_{$attendance}").load("index.php?page=attendanceBlock&key={php}echo secureform_add_pk('attendanceBlock', 60, $this->get_template_vars('attendance')){/php}&attendance={$attendance}&status=5");'>
		{#images_a_coop#}
	</a>
{/if}
{/strip}