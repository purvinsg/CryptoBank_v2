<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\TransactionFilterRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index(TransactionFilterRequest $request): Response
    {
        $user = auth()->user();
        $accounts = $user->accounts()->get();
        $searchAccount = $request->validated('search_account');
        $searchName = $request->validated('search_name');
        $startDate = $request->validated('start_date');
        $endDate = $request->validated('end_date');

        $transactions = Transaction::query()
            ->whereIn('sender_account_id', $accounts->pluck('id'))
            ->orWhereIn('recipient_account_id', $accounts->pluck('id'))
            ->with([
                'senderAccount:id,user_id,number,name,currency' => ['user:id,name'],
                'recipientAccount:id,user_id,number,name,currency' => ['user:id,name'],
            ])
            ->accountNumber($searchAccount)
            ->recipientName($searchName)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->dateRange($startDate, $endDate);
            })
            ->latest()
            ->paginate(5);

        return Inertia::render('AccountsIndex', compact('accounts', 'transactions'));
    }

    public function create(): Response
    {
        $currencies = $this->currencyRepository->all();

        return Inertia::render('CreateAccount', compact('currencies'));
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $request->user()->accounts()->create($request->validated());

        return redirect()->route('accounts.index');
    }

    public function edit(Account $account): Response
    {
        return Inertia::render('EditAccount', compact('account'));
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index');
    }
}
