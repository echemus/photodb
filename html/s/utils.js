function PhotoQuery(offset)
{
    photoReq = new XMLHttpRequest();
    photoReq.open('POST', 'photos.php', true);
    photoReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    photoReq.onload = function()
    {
        if ((4 == photoReq.readyState) && (200 == photoReq.status))
        {
            updateDiv           = document.getElementById("content-box");
            updateDiv.innerHTML = photoReq.responseText;
            updateDiv.scrollTop = 0;
        }
    };

    query = 'offset=' + offset;

    photoReq.send(query);
}

function ProcessOffsetForm()
{
    theForm = document.forms['offsetform'];

    PhotoQuery(theForm.offset.value);
}

last = null;

function UpdateTags(id)
{
        updateTagReq = new XMLHttpRequest();
        updateTagReq.open('POST', 'tags.php', true);

        updateTagReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        updateTagReq.onload = function()
        {
            if ((4 == updateTagReq.readyState) && (200 == updateTagReq.status))
            {
                document.getElementById(id + "-options").innerHTML = updateTagReq.responseText;
            }
        };

        query = 'photo=' + id;

        updateTagReq.send(query);
}

function ExpandPhotoCard(id)
{
    alreadyopen = false;
    if (last != null)
    {
        alreadyopen = (last == id);
        if (!alreadyopen)
        {
            CollapsePhotoCard(last);
        }
    }

    last = id;

    if (!alreadyopen)
    {
        card = document.getElementById(id);
        card.style.width = "545px";
        //card.style.overflow = "auto";
        UpdateTags(id);
   }
}

function CollapsePhotoCard(id)
{
    card = document.getElementById(id);
    if (card != null)
    {
        card.style.width = '260px';
        //card.style.overflow = "hidden";
        document.getElementById(id + "-options").innerHTML = "";
    }
}

function ToggleTag(id)
{
    document.getElementById("output-box").innerHTML = "Querying... ";
    checkBox     = document.getElementsByName(id);
    toggleTagReq = new XMLHttpRequest();
    toggleTagReq.open('POST', 'tag.php', true);
    toggleTagReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    tagValues = id.split('-');
    query = '&set=' + checkBox[0].checked + "&photo=" + tagValues[0] + "&tag=" + tagValues[1];

    document.getElementById("output-box").innerHTML += "<br>Query: " + query + "<br>";


    toggleTagReq.onload = function()
    {
        if ((4 == toggleTagReq.readyState) && (200 == toggleTagReq.status))
        {
            document.getElementById("output-box").innerHTML += toggleTagReq.responseText;
        }
    };

    toggleTagReq.send(query);
}

function Pressed(ev, fromPhoto, id)
{
    if ((window.event ? event.keyCode : ev.which) == 13)
    {
        AddTag(fromPhoto, id);
    }
}

function AddTag(fromPhoto, id)
{
    allTagsVisible = document.getElementById('tag-box').style.visibility == 'visible';
    inputBox = null;

    if (fromPhoto)
    {
        DebugText("<br>Adding tag in " + id, true);
        inputBox = document.getElementsByName(id + "-new");
    }
    else if (allTagsVisible)
    {
        inputBox = document.getELementsByName("alltags-new");
    }

    if (inputBox != null)
    {
        addTagReq = new XMLHttpRequest();
        addTagReq.open('POST', 'addtag.php', true);
        addTagReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        addTagReq.onload = function()
        {
            if ((4 == addTagReq.readyState) && (200 == addTagReq.status))
            {
                DebugText(addTagReq.responseText, false);
                UpdateTags(id);

                if (allTagsVisible)
                {
                    UpdateAllTags();
                }
            }
        };
        query = "newtag=" + inputBox[0].value;
        if (fromPhoto)
        {
            query += "&photo=" + id;
        }

        DebugText("<br>Sending Query " + query + "<br>", false);
        addTagReq.send(query);
    }
}

clickedTag = null;

function EditTag(photo, tag)
{
    alreadyediting = false;
    span = document.getElementById(photo + "-name-" + tag);
    if (clickedTag != null)
    {
        alreadyediting = (clickedTag == tag);

        if (!alreadyediting)
        {
            value = span.innerHTML;
            span.innerHTML = "<input type='text' value='" + value + "' name='" + photo + "-name-" + tag + "-edit" + "'>";
        }
    }
    clickedTag = tag;

    if (!alreadyediting)
    {
        tagEditor = document.getElementsByName(photo + "-name-" + tag + "-edit");
        span.innerHTML = tagEditor[0].value;
    }
}

function DebugText(newText, clear)
{
    if (clear == true)
    {
         document.getElementById("output-box").innerHTML = newText;
    }
    else
    {
         document.getElementById("output-box").innerHTML += newText;
    }
}

function Next()
{
    offset = document.getElementsByName("offset");
    max    = document.getElementsByName("max");

    offsetInt = parseInt(offset[0].value);

    maxint = parseInt(max[0].value);

    if (offsetInt + 60 > maxint)
    {
        offset[0].value = maxint - 60;
        DebugText("New Value: " + offsetInt);

    }
    else
    {
        offset[0].value = offsetInt + 60;
        DebugText("New Value: " + offsetInt);
    }
    ProcessOffsetForm();
}

function Prev()
{
    offset = document.getElementsByName("offset");
    if (offset[0].value > 60)
    {
        offset[0].value -= 60;
    }
    else
    {
        offset[0].value = 0;
    }
    ProcessOffsetForm();
}

function SelectAll()
{
   ticks = document.querySelectorAll('.totalcheck');
   for (i = 0; i < ticks.length; i++)
   {
       ticks[i].checked = true;
   }
}

function DeSelectAll()
{

   ticks = document.querySelectorAll('.totalcheck');
   for (i = 0; i < ticks.length; i++)
   {
       ticks[i].checked = false;
   }
}

function UpdateAllTags()
{

    updateAllTagReq = new XMLHttpRequest();
    updateAllTagReq.open('POST', 'alltags.php', true);
    updateAllTagReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    updateAllTagReq.onload = function()
    {
        if ((4 == updateAllTagReq.readyState) && (200 == updateAllTagReq.status))
        {
            document.getElementById('tagContent').innerHTML = updateAllTagReq.responseText;
        }
    };

    updateAllTagReq.send(query);
}

function OpenTags()
{
    UpdateAllTags();
    box = document.getElementById('tag-box');
    box.style.visibility = 'visible';
}

function HideTagAll()
{
    box = document.getElementById('tag-box');
    box.style.visibility = 'hidden';
}

function TagSelected()
{
    ticks  = document.querySelectorAll('.totalcheck');
    tags   = document.querySelectorAll('.alltagtick');
    tagStr = "";

    for (i = 0; i < tags.length; i++)
    {
        if (tags[i].checked)
        {
            if (tagStr != "")
            {
                tagStr += "-"
            }
            tagTitles = tags[i].name.split('-');
            tagStr += tagTitles[1];
        }
    }

    query = "NewTags=";

    for (i = 0; i < ticks.length; i++)
    {
        if (ticks[i].checked)
        {
            nameBits = ticks[i].name.split('-');
            query += nameBits[0] + ":" + tagStr + ";";
        }
    }
    toggleTagReq = new XMLHttpRequest();
    toggleTagReq.open('POST', 'masstag.php', true);
    toggleTagReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    toggleTagReq.onload = function()
    {
        if ((4 == toggleTagReq.readyState) && (200 == toggleTagReq.status))
        {
            document.getElementById("output-box").innerHTML += toggleTagReq.responseText;
        }
    };

    toggleTagReq.send(query);
}

debugHide = true;
function DebugToggle()
{
    if (debugHide)
    {
        document.getElementById("output-box").style.visibility = 'visible';
        debugHide = false;
    }
    else
    {
        document.getElementById("output-box").style.visibility = 'hidden';
        debugHide = true;
    }
}
