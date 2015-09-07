{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
  <h2>{$lblTeam|ucfirst}: {$lblAdd}</h2>
</div>

{form:add}
<label for="title">{$lblTitle|ucfirst}</label>
{$txtTitle} {$txtTitleError}

<div id="pageUrl">
  <div class="oneLiner">
    {option:detailURL}<p><span><a href="{$detailURL}">{$detailURL}/<span id="generatedUrl"></span></a></span></p>{/option:detailURL}
    {option:!detailURL}<p class="infoMessage">{$errNoModuleLinked}</p>{/option:!detailURL}
  </div>
</div>

<div class="tabs">
  <ul>
    <li><a href="#tabContent">{$lblContent|ucfirst}</a></li>
    <li><a href="#tabSEO">{$lblSEO|ucfirst}</a></li>
  </ul>
  <div id="tabContent">
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
  </div>
  <div id="tabSEO">
    {include:{$BACKEND_CORE_PATH}/Layout/Templates/Seo.tpl}
  </div>
</div>

<div class="fullwidthOptions">
  <div class="buttonHolderRight">
    <input id="addButton" class="button mainButton" type="submit" name="add" value="{$lblAdd|ucfirst}" />
  </div>
</div>
{/form:add}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
