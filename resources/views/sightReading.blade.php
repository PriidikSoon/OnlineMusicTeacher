@include('head')
<div id="metronomeBorderLeft" class="metronomeBorder"></div>
<div id="metronomeBorderRight" class="metronomeBorder"></div>
<div id="metronomeBorderTop" class="metronomeBorder"></div>
<div id="metronomeBorderBottom" class="metronomeBorder"></div>
        <div class="container">
            <h2>{{ $task->exercise->title }}</h2>
                <div>
                    <div>
                        <table class="taskTable">
                            <tr>
                                <td>Author: </td>
                                <td>{{ $task->exercise->author }}</td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>{{ $task->exercise->description }}</td>
                            </tr>
                            <tr>
                                <td>Task: </td>
                                <td>{{ $task->description }}</td>
                            </tr>
                            <tr>
                                <td>Due date:</td>
                                <td>{{ $task->due_date }}</td>
                            </tr>
                            <tr>
                                <td>Tempo</td>
                                <td>
                                    <select id="tempo">
                                        <?php
                                        foreach (range(40,240) as $number) {
                                            echo '<option value='.$number.'>'.$number.'</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    {{--<div>
                        <h5>Pitch</h5>
                        <span class="subtitle" id="pitch">-- Hz</span>
                    </div>
                    <div>
                        <h5>Cents</h5>
                        <span class="subtitle" id="cents"></span>
                    </div>
                    <div>
                        <h5>Note</h5>
                        <span class="subtitle" id="note">--</span>
                    </div>--}}
                </div>
            <input type="hidden" class="button" id="micButton">
            <button class="button" id="performButton">Start song</button>
            {{--<button class="button" id="clearButton">Clear</button>--}}
            <button class="button" id="metronomeButton">Metronome</button>
            <button class="button" id="detailedFeedback" onclick="VEXUTIL.toggleDetailedFeedback();">Detailed feedback</button>
            <div id="colorLegend"></div>
            <div id="musicSheet" style=""></div>
        </div>
@include('footer')

<script>
    $(function(){
        VEXUTIL.importFromXML({{ $task->exercise->user_id }},'{{ $task->exercise->file_link }}');
    });
</script>