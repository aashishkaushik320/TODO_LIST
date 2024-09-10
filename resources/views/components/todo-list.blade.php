<div>
    <h3 class="text-center">Task Listing</h3>
</div>

@if(isset($tasks) && count($tasks)>0)
<table class="table table-bordered text-center">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Task Name</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tasks as $index => $task)
        <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>{{ $task->name }}</td>
          <td>
            @if($task->is_completed)
            <span class="badge text-bg-success">Done</span>
            @else
            <span class="badge text-bg-warning">Not Completed</span>
            @endif
          </td>
          <td>
            @if(!$task->is_completed)
            <button class="btn btn-success btn-sm action" data-task-id="{{ encrypt($task->id) }}" data-type="complete">
                <i class="fa fa-check"></i>
              </button>
          @endif
          <button class="btn btn-danger btn-sm action" data-task-id="{{ encrypt($task->id) }}"  data-type="delete">
            <i class="fa fa-times"></i>
          </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

@else

<span class ="text-center">No result found</span>


@endif

