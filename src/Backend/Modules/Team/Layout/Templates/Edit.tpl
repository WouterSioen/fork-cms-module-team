{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
  <h2>{$lblTeam|ucfirst}: {$lblEdit}</h2>
</div>

{form:edit}
<label for="name">{$lblName|ucfirst}</label>
{$txtName} {$txtNameError}

<div id="pageUrl">
  <div class="oneLiner">
    {option:detailURL}<p><span><a href="{$detailURL}">{$detailURL}/<span id="generatedUrl"></span></a></span></p>{/option:detailURL}
    {option:!detailURL}<p class="infoMessage">{$errNoModuleLinked}</p>{/option:!detailURL}
  </div>
</div>

<div class="box">
  <div class="heading">
    <h3>
      <label for="description">{$lblDescription|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></label>
    </h3>
  </div>
  <div class="optionsRTE">
    {$txtDescription} {$txtDescriptionError}
  </div>
</div>

<div class="fullwidthOptions">
  {option:showTeamDelete}
  <a href="{$var|geturl:'Delete'}&amp;id={$teamMember.id}" data-message-id="confirmDelete" class="askConfirmation button linkButton icon iconDelete">
    <span>{$lblDelete|ucfirst}</span>
  </a>
  {/option:showTeamDelete}

  <div class="buttonHolderRight">
    <input id="editButton" class="inputButton button mainButton" type="submit" name="edit" value="{$lblPublish|ucfirst}" />
  </div>
</div>

<div id="confirmDelete" title="{$lblDelete|ucfirst}?" style="display: none;">
  <p>
  {$msgConfirmDelete|sprintf:{$teamMember.name}}
  </p>
</div>
{/form:edit}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
