var VEXUTIL = {};

VEXUTIL.canvas = null;
VEXUTIL.renderer = null;
VEXUTIL.context = null;
VEXUTIL.stave = null;
VEXUTIL.stavePosition = 0;
VEXUTIL.measurePosition = 0;
VEXUTIL.staveHeight = 150;
VEXUTIL.sheetHeight = 1500;
VEXUTIL.sheetWidth = window.screen.width - 100;
VEXUTIL.measuresPerLine = 4;
VEXUTIL.measureWidth = VEXUTIL.sheetWidth / VEXUTIL.measuresPerLine;
VEXUTIL.measures = [];
VEXUTIL.measureNumber = 0;
VEXUTIL.notes = [];
VEXUTIL.currentNoteIndex = 0;
VEXUTIL.currentNoteStart = false;
VEXUTIL.currentNote = false;
VEXUTIL.currentNoteIsBar = false;
VEXUTIL.ties = [];
VEXUTIL.measureFilled = 0;
VEXUTIL.beatFilled = 0;
VEXUTIL.tempo = 60;
VEXUTIL.tempoC = VEXUTIL.tempo / 60; // tempo/60
VEXUTIL.beatsInMeasure = 4;
VEXUTIL.beatType = 4;
VEXUTIL.pitchDetectionDelay = 250;
VEXUTIL.songStarted = false;
VEXUTIL.shortestLength = 7;
VEXUTIL.noteLengths = {
    1:4,
    2:2,
    4:1,
    8:0.5,
    16:0.25,
    32:0.125,
    64:0.0625
};
VEXUTIL.totalPartsInBeat = 4;
VEXUTIL.totalPartsInMeasure = VEXUTIL.beatsInMeasure * VEXUTIL.totalPartsInBeat;

VEXUTIL.partsInBeat = VEXUTIL.totalPartsInBeat;
VEXUTIL.partsInMeasure = VEXUTIL.totalPartsInMeasure;

VEXUTIL.mode = 1; // 1 - write, 2 - compare
VEXUTIL.detailedFeedback = false;

VEXUTIL.changeTempo = function(tempo){

    VEXUTIL.stopMetronome();
    VEXUTIL.tempo = tempo;
    VEXUTIL.tempoC = tempo / 60;
    VEXUTIL.toggleMetronome();
};

VEXUTIL.changeSmallestPart = function(smallestPart){
    VEXUTIL.totalPartsInBeat = VEXUTIL.partsInBeat;
    VEXUTIL.totalPartsInMeasure = 4 * VEXUTIL.partsInBeat;
};


VEXUTIL.metronomeRunning = false;
VEXUTIL.toggleMetronome = function(){
    if(VEXUTIL.metronomeRunning){
        VEXUTIL.stopMetronome();
        return false;
    }
    VEXUTIL.metronomeRunning = true;
    var time = 1000 / VEXUTIL.tempoC;
    var counterTime = time/2;
    VEXUTIL.blinkBorder(counterTime);
    VEXUTIL.metronome = setInterval(
        function(){
            VEXUTIL.blinkBorder(counterTime);
        },time
    );
};

VEXUTIL.blinkBorder = function(visibleTime){
    $(".metronomeBorder").addClass('blinkBorder');
    setTimeout(function(){
        $(".metronomeBorder").removeClass('blinkBorder');
    },visibleTime);

    /*$("body").addClass('blinkBorder');
    setTimeout(function(){
        $("body").removeClass('blinkBorder');
    },visibleTime);*/
};

VEXUTIL.stopMetronome = function(){
    clearInterval(VEXUTIL.metronome);
    VEXUTIL.metronomeRunning = false;
};

VEXUTIL.startCountdown = function(){
    var nr = VEXUTIL.beatsInMeasure;
    var counter = '<div id="countDown" style="position: fixed; left: 50%; top: 25%; font-size: 82pt">' + nr + '</div>';
    $("body").append(counter);
    var counterEl = $("#countDown");
    var oneBeatTime = 1 / VEXUTIL.tempoC * 1000;
    var count = setInterval(function(){
        nr--;
        if(nr == 0){
            clearInterval(count);
            counterEl.remove();
        }else{
            counterEl.text(nr);
        }
    }, oneBeatTime);
};

VEXUTIL.isBeatFilled = function(){
    return VEXUTIL.partsInBeat <= 0;
};

VEXUTIL.beatIsEmpty = function(){
    return VEXUTIL.partsInBeat == VEXUTIL.totalPartsInBeat;
};

VEXUTIL.isMeasureFilled = function(){
    return VEXUTIL.partsInMeasure == 0;
};

var VexDocument = null;
var VexFormatter = null;

VEXUTIL.importFromXML = function(userID, fileName) {
    $.ajax({
        url: "getMusicXML?userID=" + userID + "&fileName=" + fileName,
        success: function(data) {
            var musicSheet = $("#musicSheet");
            VexDocument = new Vex.Flow.Document(data);
            var content = musicSheet[0];
            if (VexDocument) {
                VexFormatter = VexDocument.getFormatter();
                VexFormatter.draw(content, {canvasType: 'svg'});
            }
            VEXUTIL.readNotesIn(VexFormatter.document.measures);
            VEXUTIL.makeStavesHigher(50);
        }
    });
};

VEXUTIL.makeStavesHigher = function(plusHeight) {
    var musicSheet = $("#musicSheet");
    var viewBoxes = musicSheet.find('svg:not([id])');
    $(viewBoxes).each(function(index, viewBox){
        var viewBoxString = $(viewBox).attr('viewBox');
        var viewBoxVariables = viewBoxString.split(' ');
        viewBoxVariables[3] = parseInt(viewBoxVariables[3]) + plusHeight;
        $(viewBox).attr('viewBox', viewBoxVariables.join(' '));
    });
};

VEXUTIL.readNotesIn = function(measures){
    VEXUTIL.measures = [];
    VEXUTIL.notes = [];
    VEXUTIL.mode = 0;

    $(measures).each(function(index, measure){
        $(measure.parts[0].voices[0].notes).each(function(index2, note){
            VEXUTIL.notes.push(note);
        });
        VEXUTIL.notes.push(new Vex.Flow.BarNote());
    });
    //VEXUTIL.setCanvas(true);
};

VEXUTIL.sepapoisid = function(){
    VEXUTIL.measures = [];
    VEXUTIL.notes = [];
    VEXUTIL.mode = 0;
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("D/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));

    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("D/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));

    VEXUTIL.notes.push(new Vex.Flow.BarNote());

    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("F/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "4"));

    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("F/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "4"));

    VEXUTIL.notes.push(new Vex.Flow.BarNote());

    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("A/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("F/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));

    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("A/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("F/5", "16"));
    VEXUTIL.notes.push(VEXUTIL.createNote("E/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));

    VEXUTIL.notes.push(new Vex.Flow.BarNote());

    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/4", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "4"));

    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("G/4", "8"));
    VEXUTIL.notes.push(VEXUTIL.createNote("C/5", "4"));

    VEXUTIL.notes.push(new Vex.Flow.BarNote());

    VEXUTIL.setCanvas(true);
};

VEXUTIL.currentSongNote = false;
VEXUTIL.lastSongNote = false;
VEXUTIL.lastPlayedNote = false;

VEXUTIL.songTimer = null;
VEXUTIL.songTime = 0;
VEXUTIL.lastPlayedSongNoteStartTime = 0;

VEXUTIL.startTime = 0;
// use system time
VEXUTIL.startSongTimer = function(notes){
    VEXUTIL.currentSongNote = notes[0];
    VEXUTIL.currentSongNote.index = 0;
    VEXUTIL.colorNote(VEXUTIL.currentSongNote, "red", "red");
    var startTime = new Date().getTime();
    //console.log("startTime: " + startTime);
    VEXUTIL.songTimer = setInterval(function(){
        VEXUTIL.songTime = Math.floor((new Date().getTime() - startTime - VEXUTIL.pitchDetectionDelay));
            if(VEXUTIL.currentSongNote.endTime <= VEXUTIL.songTime /** / 1000 */){
                VEXUTIL.getNextNote(notes);
                //console.log("songTime: " + VEXUTIL.songTime);
                //console.log("currentSongNote ", VEXUTIL.currentSongNote.keys[0]);
                VEXUTIL.colorNote(VEXUTIL.currentSongNote, "red", "red"); // Kuhugi mujale see!!
            }
    }, 10)
};

VEXUTIL.getNextNote = function(notes){
    var nextIndex = VEXUTIL.currentSongNote.index + 1;
    if(typeof notes[nextIndex] !== "undefined"){
        if(VEXUTIL.isStaveNote(VEXUTIL.currentSongNote))VEXUTIL.lastSongNote = VEXUTIL.currentSongNote;
        VEXUTIL.currentSongNote = notes[nextIndex];
        VEXUTIL.currentSongNote.index = nextIndex;
        if(!VEXUTIL.isStaveNote(VEXUTIL.currentSongNote)){
            VEXUTIL.getNextNote(notes);
        }
    }else{
        VEXUTIL.colorNote(VEXUTIL.currentSongNote, "black", "black");
        VEXUTIL.stopSongTimer();
        VEXUTIL.stopMetronome();
        $('#micButton').click();
    }
};

VEXUTIL.stopSongTimer = function(){
    clearInterval(VEXUTIL.songTimer);
};

VEXUTIL.calculateNoteTimeline = function(notes){
    var lastNoteEnd = 0;
    for(var i in notes){
        if(notes.hasOwnProperty(i)){
            var note = notes[i];
            //if(note.attrs.type !== "StaveNote") continue;
            if(!VEXUTIL.isStaveNote(note)) continue;
            note.startTime = lastNoteEnd;
            var duration = note.duration;
            var hasDot = VEXUTIL.hasDot(duration);
            if(hasDot) duration = parseInt(duration.split('d')[0]);
            if(VEXUTIL.isTuplet(note)){
                duration = 1/((1 / note.duration) * note.tuplet.beats_occupied / note.tuplet.num_notes);
            }
            var noteTime = (1 / (duration / 4)) / VEXUTIL.tempoC * 1000;
            if(hasDot) noteTime = noteTime * 1.5;
            note.endTime = lastNoteEnd +  noteTime;
            lastNoteEnd = note.endTime;
        }
    }
};

VEXUTIL.hasDot = function(noteDuration){
    return noteDuration.indexOf('d') !== -1;
};

VEXUTIL.isTuplet = function(note) {
    return note.tuplet !== null;
};

VEXUTIL.isStaveNote = function(note){
    //return note.attrs.type == "StaveNote";
    return note.duration !== "b";
};

VEXUTIL.startSong = function(notes){
    $('#micButton').click();
    VEXUTIL.stopMetronome();
    VEXUTIL.calculateNoteTimeline(notes);
    VEXUTIL.resetNoteColors(notes);
    var oneMeasureTime = 1/VEXUTIL.tempoC * VEXUTIL.beatsInMeasure * 1000;
    VEXUTIL.startCountdown();
    setTimeout(function(){
        VEXUTIL.toggleMetronome();
        VEXUTIL.startSongTimer(notes);
    }, oneMeasureTime);
};

VEXUTIL.colorNote = function(note, color, stroke){
    if(typeof stroke == 'undefined') stroke = false;
    //var noteID = note.attrs.id;
    var noteID = note.staveID;
    var notePath = $('#vf-' + noteID).find("path");
    notePath.attr({fill: color});
    if(stroke !== false){
        notePath.attr({"stroke": stroke, "stroke-width":2});
    }

};

VEXUTIL.resetNoteColors = function(notes){
    for(var i in notes){
        if(notes.hasOwnProperty(i)){
            VEXUTIL.colorNote(notes[i], "black", "black");
        }
    }
};

VEXUTIL.compareNotes = function(lastNote, lastNoteStartTime, lastNoteEndTime){
    var playedNote = {};
    playedNote.key = lastNote;
    playedNote.startTime = lastNoteStartTime;// / 1000;
    playedNote.endTime = lastNoteEndTime;// / 1000;
    var comparedNote = VEXUTIL.lastSongNote;
    //console.log("last");
    var compare = {};
    compare.rightNote = false;
    compare.color = 'red';
    compare.stroke = false;

    if(VEXUTIL.lastSongNote){
        compare = VEXUTIL.compareNote(VEXUTIL.lastSongNote, playedNote);
    }
    if(!compare.rightNote){
        //console.log("current");
        compare = VEXUTIL.compareNote(VEXUTIL.currentSongNote, playedNote);
        comparedNote = VEXUTIL.currentSongNote;
    }else{
        if(!(compare.color == 'green')){
            compare = VEXUTIL.compareNote(VEXUTIL.currentSongNote, playedNote);
            comparedNote = VEXUTIL.currentSongNote;
        }
    }
    if(compare.rightNote){
        VEXUTIL.colorNote(comparedNote, compare.color, compare.stroke);
    }
};

VEXUTIL.allowedLengthError = 150;

VEXUTIL.colorStartEarly = '#ffff80';
VEXUTIL.colorStartLate = '#e1e100';
VEXUTIL.colorEndEarly = '#ffedcc';
VEXUTIL.colorEndLate = '#ffa500';

VEXUTIL.createLegend = function()
{
    var div = $('#colorLegend');
    if(VEXUTIL.detailedFeedback){
        div.html('' +
            '<table>' +
            '<tr>' +
            '<td><div class="colorBox" style="background-color: green"></div></td>' +
            '<td>Correct</td>' +
            '<td><div class="colorBox" style="background-color: red"></div></td>' +
            '<td>Wrong</td>' +
            '</tr>' +
            '<tr>' +
            '<tr>' +
            '<td><div class="colorBox" style="background-color: ' + VEXUTIL.colorStartEarly + '"></div></td>' +
            '<td>Start early</td>' +
            '<td><div class="colorBox" style="background-color: ' + VEXUTIL.colorStartLate + '"></div></td>' +
            '<td>Start late</td>' +
            '</tr>' +
            '<tr>' +
            '<td><div class="colorBox" style="background-color: ' + VEXUTIL.colorEndEarly + '"></div></td>' +
            '<td>End early</td>' +
            '<td><div class="colorBox" style="background-color: ' + VEXUTIL.colorEndLate + '"></div></td>' +
            '<td>End late</td>' +
            '</tr>' +
            '</table>');
    }else{
        div.html('' +
            '<table>' +
            '<tr>' +
            '<td><div class="colorBox" style="background-color: green"></div></td>' +
            '<td>Correct</td>' +
            '<td><div class="colorBox" style="background-color: red"></div></td>' +
            '<td>Wrong</td>' +
            '</tr>' +
            '</table>');
    }
};

VEXUTIL.toggleDetailedFeedback = function(){
    var el = $('#detailedFeedback');
    if(el.text() == 'Detailed feedback'){
        VEXUTIL.detailedFeedback = true;
        el.text('Simple feedback');
    }else{
        VEXUTIL.detailedFeedback = false;
        el.text('Detailed feedback');
    }
    VEXUTIL.createLegend();
};

VEXUTIL.compareNote = function(songNote, playedNote){
    var compare = {};
    compare.rightNote = false;
    compare.color = 'red';
    compare.stroke = false;
    if(!VEXUTIL.isStaveNote(songNote)) return false;

    //console.log("played Note: " + playedNote.key, "start: " + playedNote.startTime, "end: " + playedNote.endTime);

    if(playedNote.key == songNote.keys[0]){

        // early
        if(playedNote.startTime < (songNote.startTime - VEXUTIL.allowedLengthError)){
            compare.color = VEXUTIL.colorStartEarly;
        // late
        }else if(playedNote.startTime > (songNote.startTime + VEXUTIL.allowedLengthError)){
            compare.color = VEXUTIL.colorStartLate;
        }
        if(playedNote.endTime < (songNote.endTime - VEXUTIL.allowedLengthError)){
            compare.stroke = VEXUTIL.colorEndEarly;
        }else if(playedNote.endTime > (songNote.endTime + VEXUTIL.allowedLengthError)){
            compare.stroke = VEXUTIL.colorEndLate;
        }
        compare.rightNote = true;
    }

    if(compare.rightNote) {
        if(compare.color == 'red'){
            compare.color = 'green';
            compare.stroke = 'green';
        }else{
            if(!VEXUTIL.detailedFeedback){
                compare.color = 'red';
                compare.stroke = false;
            }
        }
        if(compare.stroke === false){
            compare.stroke = compare.color;
        }
    }
    return compare;
};

VEXUTIL.setCanvas = function(reset)
{
    VEXUTIL.renderer.resize(VEXUTIL.sheetWidth,VEXUTIL.sheetHeight);
    VEXUTIL.context = VEXUTIL.renderer.getContext();
    if(reset){
        //VEXUTIL.context.clearRect(0, 0, VEXUTIL.canvas.width, VEXUTIL.canvas.height);
        VEXUTIL.context.clearRect(0, 0, VEXUTIL.sheetWidth, VEXUTIL.sheetHeight);
        VEXUTIL.stavePosition = 0;
    }
    if(VEXUTIL.mode == 1){
        VEXUTIL.stavePosition -= VEXUTIL.staveHeight;
        VEXUTIL.addStaveMeasure(true);
    }else{
        VEXUTIL.addStave();
    }
    var currentNotes = [];
    VEXUTIL.measureNumber = 0;
    $(VEXUTIL.measures).each(function(index, measure){
        if(VEXUTIL.measureNumber == VEXUTIL.measuresPerLine){
            var beams = Vex.Flow.Beam.generateBeams(currentNotes);
            Vex.Flow.Formatter.FormatAndDraw(VEXUTIL.context, VEXUTIL.stave, currentNotes);
            beams.forEach(function(b) {b.setContext(VEXUTIL.context).draw()});
            VEXUTIL.addStave();
            VEXUTIL.measureNumber = 0;
            //console.log(currentNotes);
            currentNotes = [];
        }
        currentNotes =  currentNotes.concat(measure);
        VEXUTIL.measureNumber++;
    });

    currentNotes = currentNotes.concat(VEXUTIL.notes);
    var beams = Vex.Flow.Beam.generateBeams(currentNotes);
    Vex.Flow.Formatter.FormatAndDraw(VEXUTIL.context, VEXUTIL.stave, currentNotes);
    VEXUTIL.ties.forEach(function(t) {t.setContext(VEXUTIL.context).draw()});
    beams.forEach(function(b) {b.setContext(VEXUTIL.context).draw()});
};

VEXUTIL.addToCanvas = function(reset){
    //console.log("ADDING TO CANVAS!!!");
    VEXUTIL.renderer.resize(VEXUTIL.sheetWidth,VEXUTIL.sheetHeight);
    VEXUTIL.context = VEXUTIL.renderer.getContext();
    //if(VEXUTIL.currentNoteIsBar) VEXUTIL.measureNumber++;
    if(reset){
        //console.log(VEXUTIL.measurePosition);
        VEXUTIL.context.clearRect(VEXUTIL.measurePosition, VEXUTIL.stavePosition, VEXUTIL.measureWidth, VEXUTIL.staveHeight);
        VEXUTIL.addStaveMeasure(false);
    }

    var currentNotes = VEXUTIL.notes;
    var currentStave = VEXUTIL.stave;
    if(VEXUTIL.currentNoteIsBar){
        currentNotes = VEXUTIL.measures[VEXUTIL.measures.length - 1];
        VEXUTIL.measureNumber++;
        VEXUTIL.measurePosition += VEXUTIL.measureWidth;
        if(VEXUTIL.measureNumber == VEXUTIL.measuresPerLine){
            VEXUTIL.addStaveMeasure(true);
            VEXUTIL.measurePosition = 0;
            VEXUTIL.measureNumber = 0;
        }else{
            VEXUTIL.addStaveMeasure(false);
        }
        VEXUTIL.currentNoteIsBar = false;
    }

    var beams = Vex.Flow.Beam.generateBeams(currentNotes);
    Vex.Flow.Formatter.FormatAndDraw(VEXUTIL.context, currentStave, currentNotes);
    beams.forEach(function(b) {b.setContext(VEXUTIL.context).draw()});
    VEXUTIL.ties.forEach(function(t) {t.setContext(VEXUTIL.context).draw()});

};

VEXUTIL.addStave = function() {
    VEXUTIL.stave = new Vex.Flow.Stave(0, VEXUTIL.stavePosition, VEXUTIL.sheetWidth);
    VEXUTIL.stave.addClef("treble");
    VEXUTIL.stave.setContext(VEXUTIL.context).draw();
    VEXUTIL.stavePosition += VEXUTIL.staveHeight;
};

VEXUTIL.addStaveMeasure = function(newRow){
    if(newRow) VEXUTIL.stavePosition += VEXUTIL.staveHeight;
    VEXUTIL.stave = new Vex.Flow.Stave(VEXUTIL.measurePosition, VEXUTIL.stavePosition, VEXUTIL.measureWidth);
    if(VEXUTIL.measureNumber == 0) VEXUTIL.stave.addClef("treble");
    VEXUTIL.stave.setContext(VEXUTIL.context).draw();
};

VEXUTIL.addNote = function(note, durationInSeconds) {
    VEXUTIL.currentNoteStart = false;
    //console.log("addNote: " + note + " - " + durationInSeconds +"s");
    var startIndex = VEXUTIL.currentNoteIndex;
    var parts = VEXUTIL.getNumberOfSmallestParts(durationInSeconds);
    //console.log(parts);
    if(parts == 0) return false;
    if(parts > VEXUTIL.partsInBeat){
        //console.log("parts is greater than parts in beat");
        if(VEXUTIL.beatIsEmpty()){
            //console.log("beat is empty");
            while(parts > VEXUTIL.partsInMeasure){
                //console.log(parts, VEXUTIL.partsInMeasure);
                parts -= VEXUTIL.partsInMeasure;
                VEXUTIL.addNoteLengths(note, VEXUTIL.partsInMeasure);
                //VEXUTIL.addMeasureBar();
            }
            VEXUTIL.addNoteLengths(note, parts);
        }else{
            //console.log("beat is not empty");
            //console.log(VEXUTIL.partsInBeat);
            parts -= VEXUTIL.partsInBeat;
            VEXUTIL.addNoteLengths(note, VEXUTIL.partsInBeat);
            VEXUTIL.addNoteLengths(note, parts);
        }
    }else{
        VEXUTIL.addNoteLengths(note, parts);
    }
    if(VEXUTIL.isMeasureFilled())
    {
        VEXUTIL.addMeasureBar();
    }
    var currentNoteIndex = VEXUTIL.currentNoteIsBar ? VEXUTIL.currentNoteIndex - 2 : VEXUTIL.currentNoteIndex - 1;
    //if(startIndex !== currentNoteIndex && note != "--"){
    if(VEXUTIL.currentNoteStart !== VEXUTIL.currentNote && note != "--"){
        //console.log("tie: " + startIndex, VEXUTIL.currentNoteStart, currentNoteIndex, VEXUTIL.currentNote);
        VEXUTIL.addTie(VEXUTIL.currentNoteStart, VEXUTIL.currentNote);
    }
    if(VEXUTIL.mode == 1){
        VEXUTIL.addToCanvas(true);
    }else{
        VEXUTIL.setCanvas(true);
    }
};

VEXUTIL.addNoteLengths = function(note, parts){
    var noteLengths = VEXUTIL.partsToLengths(parts);
    for(var length in noteLengths){
        if(noteLengths.hasOwnProperty(length)){
            //console.log("note length: " + length);
            VEXUTIL.notes.push(VEXUTIL.createNote(note, length));
            VEXUTIL.partsInBeat -= VEXUTIL.totalPartsInMeasure/length;
            VEXUTIL.partsInMeasure -= VEXUTIL.totalPartsInMeasure/length;
            if(VEXUTIL.isBeatFilled()) VEXUTIL.partsInBeat = VEXUTIL.totalPartsInBeat;
            if(VEXUTIL.isMeasureFilled()){
                VEXUTIL.addMeasureBar();
            }
        }
    }
    //console.log("PIB: " + VEXUTIL.partsInBeat, "PIM: " + VEXUTIL.partsInMeasure);
};

VEXUTIL.addMeasureBar = function(){
    //console.log("ADDING MEASURE BAR!!!");
    if(VEXUTIL.mode != 1){
        VEXUTIL.notes.push(
            new Vex.Flow.BarNote()
        );
    }
    VEXUTIL.measures.push(VEXUTIL.notes);
    VEXUTIL.notes = [];
    VEXUTIL.currentNoteIndex++;
    VEXUTIL.currentNoteIsBar = true;
    VEXUTIL.partsInMeasure = VEXUTIL.totalPartsInMeasure;
    if(VEXUTIL.mode == 1){
        VEXUTIL.addToCanvas(true);
    }
};

VEXUTIL.addTie = function(startNote, endNote){
    var tie = new Vex.Flow.StaveTie({
        first_note: startNote,
        last_note: endNote,
        first_indices: [0],
        last_indices: [0]
    });
    VEXUTIL.ties.push(tie);
};

VEXUTIL.createNote = function(note, duration){
    var durationString = duration.toString();
    if(note == "--"){
        durationString += "r";
        note = "B/4";
    }
    var staveNote = new Vex.Flow.StaveNote({ keys: [note], duration: durationString });
    //staveNote
    //console.log(note);
    if(note.indexOf("#") >= 0){
        staveNote.addAccidental(0, new Vex.Flow.Accidental("#"));
    }
    if(note.indexOf("b") >= 0){
        staveNote.addAccidental(0, new Vex.Flow.Accidental("b"));
    }
    if(note.indexOf("d") >= 0){
        staveNote.addDotToAll();
    }
    VEXUTIL.currentNoteIndex++;
    VEXUTIL.currentNoteIsBar = false;
    if(VEXUTIL.currentNoteStart === false){
        VEXUTIL.currentNoteStart = staveNote;
    }
    if(note !== "B/4"){
        VEXUTIL.currentNote = staveNote;
    }
    return staveNote;
};

VEXUTIL.getNumberOfSmallestParts = function(duration){
    return Math.round(VEXUTIL.tempoC * duration * VEXUTIL.totalPartsInBeat);
};

VEXUTIL.partsToLengths = function(parts){
    var lengths = {};
    var run = true;
    var currentLength = VEXUTIL.totalPartsInMeasure;
    while(run){
        if(parts % 2 == 0){
            parts = parts/2;
            currentLength = currentLength/2;
            if(currentLength == 1){
                if(typeof lengths[currentLength] == "undefined") lengths[currentLength] = 0;
                run = false;
                lengths[currentLength] += parts;
            }
        }else{
            if(typeof lengths[currentLength] == "undefined") lengths[currentLength] = 0;
            lengths[currentLength]++;
            parts--;
            if(parts == 0) run = false;
        }
    }
    return lengths;
};

$(document).ready(function () {
    'use strict';
    VEXUTIL.canvas = document.getElementById("myCanvas");
    //VEXUTIL.renderer = new Vex.Flow.Renderer(VEXUTIL.canvas, Vex.Flow.Renderer.Backends.CANVAS);
    VEXUTIL.div = document.getElementById('musicSheet');
    VEXUTIL.renderer = new Vex.Flow.Renderer(VEXUTIL.div, Vex.Flow.Renderer.Backends.SVG);
    VEXUTIL.setCanvas(false);
    //VEXUTIL.sepapoisid();


    VEXUTIL.createLegend();

    /**
     * Microphone input and pitch detection code from:
     * https://developer.microsoft.com/en-us/microsoft-edge/testdrive/demos/webaudiotuner/
     */

    var baseFreq = 440;
    var isMicrophoneInUse = false;
    var frameId,
        freqTable,
        micStream,
        notesArray,
        audioContext,
        sourceAudioNode,
        analyserAudioNode;
    var lastNoteStartTime = 0;
    var lastNote = "--";
    var noteMinLength = 0.01;

    var isAudioContextSupported = function () {
        // This feature is still prefixed in Safari
        window.AudioContext = window.AudioContext || window.webkitAudioContext;
        if (window.AudioContext) {
            return true;
        }
        else {
            return false;
        }
    };

    var reportError = function (message) {
        alert(message);
    };

    var init = function () {
        $.getJSON('js/notes.json', function (data) {
            freqTable = data;
        });
        if (isAudioContextSupported()) {
            audioContext = new window.AudioContext();
        }
        else {
            reportError('AudioContext is not supported in this browser');
        }
    };

    var updatePitch = function (pitch) {
        $('#pitch').text(pitch + ' Hz');
    };

    var updateNote = function (note) {
        //console.log("updating Note: " + note + ", songTime: " + VEXUTIL.songTime);
        if(lastNote != note){
            var lastNoteLength = getLastNoteLength();
            if(lastNoteLength > noteMinLength){
                if(VEXUTIL.mode == 1){
                    VEXUTIL.addNote(lastNote, lastNoteLength);
                }else{
                    VEXUTIL.compareNotes(lastNote, VEXUTIL.lastPlayedSongNoteStartTime, VEXUTIL.songTime);
                    VEXUTIL.lastPlayedSongNoteStartTime = VEXUTIL.songTime;
                }
            }
            lastNote = note;
            $('#note').text(note);
        }
    };

    var getLastNoteLength = function(){
        var time = performance.now();
        if(lastNoteStartTime == 0){
            lastNoteStartTime = time;
            VEXUTIL.lastPlayedSongNoteStartTime = VEXUTIL.songTime;
            return 0;
        }
        var lastNoteLengthms = time - lastNoteStartTime;
        var lastNoteLength = lastNoteLengthms / 1000;
        if(lastNoteLength > noteMinLength){
            lastNoteStartTime = time;
        }
        return lastNoteLength;
    };

    var updateCents = function (cents) {
        $('#cents').text(cents);
    };

    var isGetUserMediaSupported = function () {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        if ((navigator.mediaDevices && navigator.mediaDevices.getUserMedia) || navigator.getUserMedia) {
            return true;
        }
        alert("get user media not supported! Cannot get microphone input!");
        return false;
    };

    var findFundamentalFreq = function (buffer, sampleRate) {
        // We use Autocorrelation to find the fundamental frequency.

        // In order to correlate the signal with itself (hence the name of the algorithm), we will check two points 'k' frames away.
        // The autocorrelation index will be the average of these products. At the same time, we normalize the values.
        // Source: http://www.phy.mty.edu/~suits/autocorrelation.html
        // Assuming the sample rate is 48000Hz, a 'k' equal to 1000 would correspond to a 48Hz signal (48000/1000 = 48),
        // while a 'k' equal to 8 would correspond to a 6000Hz one, which is enough to cover most (if not all)
        // the notes we have in the notes.json?_ts=1485571503430 file.
        var n = 1024;
        var bestK = -1;
        var bestR = 0;
        for (var k = 8; k <= 1000; k++) {
            var sum = 0;

            for (var i = 0; i < n; i++) {
                sum += ((buffer[i] - 128) / 128) * ((buffer[i + k] - 128) / 128);
            }

            var r = sum / (n + k);

            if (r > bestR) {
                bestR = r;
                bestK = k;
            }

            if (r > 0.9) {
                // Let's assume that this is good enough and stop right here
                break;
            }
        }

        if (bestR > 0.0025) {
            // The period (in frames) of the fundamental frequency is 'bestK'. Getting the frequency from there is trivial.
            var fundamentalFreq = sampleRate / bestK;
            return fundamentalFreq;
        }
        else {
            // We haven't found a good correlation
            return -1;
        }
    };

    var findClosestNote = function (freq, notes) {
        // Use binary search to find the closest note
        var low = -1;
        var high = notes.length;
        while (high - low > 1) {
            var pivot = Math.round((low + high) / 2);
            if (notes[pivot].frequency <= freq) {
                low = pivot;
            } else {
                high = pivot;
            }
        }

        if (Math.abs(notes[high].frequency - freq) <= Math.abs(notes[low].frequency - freq)) {
            // notes[high] is closer to the frequency we found
            return notes[high];
        }

        return notes[low];
    };

    var findCentsOffPitch = function (freq, refFreq) {
        // We need to find how far freq is from baseFreq in cents
        var log2 = 0.6931471805599453; // Math.log(2)
        var multiplicativeFactor = freq / refFreq;

        // We use Math.floor to get the integer part and ignore decimals
        var cents = Math.floor(1200 * (Math.log(multiplicativeFactor) / log2));
        return cents;
    };

    var detectPitch = function () {
        var buffer = new Uint8Array(analyserAudioNode.fftSize);
        analyserAudioNode.getByteTimeDomainData(buffer);

        var fundalmentalFreq = findFundamentalFreq(buffer, audioContext.sampleRate);

        if (fundalmentalFreq !== -1) {
            var note = findClosestNote(fundalmentalFreq, notesArray);
            var cents = findCentsOffPitch(fundalmentalFreq, note.frequency);
            updateNote(note.note);
            updateCents(cents);
        }
        else {
            updateNote('--');
            updateCents(-50);
        }

        frameId = window.requestAnimationFrame(detectPitch);
    };

    var streamReceived = function (stream) {
        micStream = stream;

        analyserAudioNode = audioContext.createAnalyser();
        analyserAudioNode.fftSize = 2048;

        sourceAudioNode = audioContext.createMediaStreamSource(micStream);
        sourceAudioNode.connect(analyserAudioNode);

        detectPitch();
    };

    var turnOffMicrophone = function () {
        if (sourceAudioNode && sourceAudioNode.mediaStream && sourceAudioNode.mediaStream.stop) {
            sourceAudioNode.mediaStream.stop();
        }
        sourceAudioNode = null;
        updatePitch('--');
        updateNote('--');
        updateCents(-50);
        analyserAudioNode = null;
        window.cancelAnimationFrame(frameId);
        isMicrophoneInUse = false;
    };

    var turnOnMicrophone = function(){
        if (isGetUserMediaSupported()) {
            notesArray = freqTable[baseFreq.toString()];

            var getUserMedia = navigator.mediaDevices && navigator.mediaDevices.getUserMedia ?
                navigator.mediaDevices.getUserMedia.bind(navigator.mediaDevices) :
                function (constraints) {
                    return new Promise(function (resolve, reject) {
                        navigator.getUserMedia(constraints, resolve, reject);
                    });
                };

            getUserMedia({audio: true}).then(streamReceived).catch(reportError);
            updatePitch(baseFreq);
            isMicrophoneInUse = true;
        }
        else {
            reportError('It looks like this browser does not support getUserMedia. ' +
                'Check <a href="http://caniuse.com/#feat=stream">http://caniuse.com/#feat=stream</a> for more info.');
        }
    };

    var toggleMicrophone = function () {
        if (!isMicrophoneInUse) {
            turnOnMicrophone();
        }
        else {
            turnOffMicrophone();
        }
    };

    var tempoSelect = $('#tempo');
    $(tempoSelect).change(function(){
        VEXUTIL.changeTempo($(this).val());
    });
    $(tempoSelect).val(VEXUTIL.tempo);
    $('#micButton').click(toggleMicrophone);
    $('#performButton').click(function(){
        VEXUTIL.startSong(VEXUTIL.notes);
    });
    $('#clearButton').click(function(){
        VEXUTIL.notes = [];
        VEXUTIL.measures = [];
        VEXUTIL.ties = [];
        VEXUTIL.measurePosition = 0;
        lastNoteStartTime = 0;
        VEXUTIL.partsInBeat = VEXUTIL.totalPartsInBeat;
        VEXUTIL.partsInMeasure = VEXUTIL.totalPartsInMeasure;
        VEXUTIL.currentNoteIndex = 0;
        VEXUTIL.setCanvas(true);
    });
    $('#metronomeButton').click(VEXUTIL.toggleMetronome);
    init();
});
