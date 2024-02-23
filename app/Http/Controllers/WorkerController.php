<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\PayrollReport;
use App\Models\Worker;
use App\Models\WorkersWages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WorkerController extends Controller
{
    //

    public function create()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin =  $characters[rand(0, strlen($characters) - 1)]. mt_rand(10000, 99999) ;
        // shuffle the result
        $string = str_shuffle($pin);
        return view('workers.create',compact('string'));
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'employee_id' => 'required|unique:workers',
            'contact_details' => 'required',
            'salary_type' => 'required|in:weekly,monthly',
            'hours_worked'=>'required|integer'
        ]);

        // Create worker
        $worker = Worker::create($request->all());
        $attendance=Attendance::create([
        'worker_id' =>$worker->id,
        'date'=>Carbon::today()->toDateString(),
        'hours_worked'=>$request->hours_worked,
        ]);

        return redirect('/create');
    }

    public function calculateWeeklySalary($id)
    {
        $worker = Worker::findOrFail($id);
        $attendance=Attendance::where('worker_id',$id)->first();

        if ($worker->salary_type === 'weekly') {
            // Assuming hourly rate is stored in the database
            $salaryperday=100;
            $hourlyRate = $attendance->hours_worked;

            // Retrieve attendance records for the last 7 days
            $startDate = $attendance->date;
            $endDate = now()->endOfDay();
            $totalHoursWorked = $worker->attendance()
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('hours_worked');

            // Calculate weekly salary
            $weeklySalary = $totalHoursWorked * $salaryperday;

             $weeklyWage = WorkersWages::create([
                'worker_id'=>$id,
                'weekly_salary'=> $weeklySalary,
                'salary_type' => 'weekly',
                'monthly_salary' => null
                
             ]);
             return redirect('/create');
            // return response()->json(['weekly_salary' => $weeklySalary]);
        } else {
            return response()->json(['message' => 'This worker is not on weekly salary.'], 422);
        }
    }


    public function calculateMonthlySalary($id)
    {
        $worker = Worker::findOrFail($id);
        $attendance=Attendance::where('worker_id',$id)->first();

        if ($worker->salary_type === 'monthly') {
            // Assuming hourly rate is stored in the 
            
            $hourlyRate = $attendance->hours_worked;
            $salaryperday=100;
            // Retrieve attendance records for the current month
            $startDate = $attendance->date;
            $endDate = now()->endOfMonth();
                          
            // Calculate the total number of working days in the current month
          $totalWorkingDays = $this->getTotalWorkingDays($startDate);
          $totalHoursWorked = $salaryperday * $totalWorkingDays;

            // Calculate monthly salary
            $monthlySalary = ($totalHoursWorked / ($totalWorkingDays * 8)) * $hourlyRate * 8 * $totalWorkingDays;
            $weeklyWage = WorkersWages::create([
                'worker_id'=>$worker->id,
                'weekly_salary'=> null,
                'salary_type' => 'monthly',
                'monthly_salary' => $monthlySalary,
             ]);


            // return response()->json(['monthly_salary' => $monthlySalary]);
        } else {
            return response()->json(['message' => 'This worker is not on monthly salary.'], 422);
        }
    }

    // Helper method to calculate the total number of working days in a given month
    private function getTotalWorkingDays($date)
    {
         
        $carbon=Carbon::parse($date);
        $daysInMonth = $carbon->daysInMonth;


// Now you can safely use the copy() method
      $result = $carbon->copy();


// Extract integer value from Carbon instance and then perform arithmetic operation 
        $totalWorkingDays = 0;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            if ($result->setDay($i)->isWeekday()) {
                $totalWorkingDays++;
            }
        }

        return $totalWorkingDays;
    }

    public function generatePayrollReport()
    {
        // Retrieve all workers
        $workers = Worker::all();

        // Initialize variables
        $totalWeeklyPayroll = 0;
        $payrollReport = [];

        // Calculate weekly wages and build payroll report
        foreach ($workers as $worker) {
            // Calculate worker's weekly wage based on attendance records
            // return $worker->id;
            // $weeklyWage = $this->calculateWeeklyWage($worker);
            
            // Sum up weekly wages to obtain total weekly payroll
            
           $weeklyWage=WorkersWages::where('worker_id',$worker->id)->first();
            // Store worker's weekly pay details for the report
            $totalWeeklyPayroll += $weeklyWage->weekly_salary;
            $payrollReport[] = [
                'name' => $worker->name,
                'employee_id' => $worker->employee_id,
                'weekly_wage' => $weeklyWage,
            ];
        }
              
        $payrollReport=PayrollReport::create($payrollReport);
        // Output the total weekly payroll and the payroll report
        return response()->json([
            'total_weekly_payroll' => $totalWeeklyPayroll,
            'payroll_report' => $payrollReport,
        ]);
    }

}
