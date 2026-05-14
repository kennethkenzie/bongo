"use client";

import { createContext, useContext, useEffect, useState } from "react";
import type { Currency } from "@/lib/types";

const fallback: Currency = {
  code: "USD",
  name: "US Dollar",
  symbol: "$",
  exchange_rate: 1,
  is_default: true,
  is_active: true
};

const CurrencyContext = createContext<Currency>(fallback);
const API = process.env.NEXT_PUBLIC_API_URL || "http://localhost:8000/api/v1";
const USE_MOCK = (process.env.NEXT_PUBLIC_USE_MOCK ?? "true") === "true";

export function CurrencyProvider({ initialCurrency, children }: { initialCurrency?: Currency; children: React.ReactNode }) {
  const [currency, setCurrency] = useState<Currency>(initialCurrency ?? fallback);

  useEffect(() => {
    if (USE_MOCK) return;
    fetch(`${API}/settings/currency`, { cache: "no-store" })
      .then((res) => (res.ok ? res.json() : Promise.reject(res)))
      .then((data) => setCurrency(data))
      .catch(() => {});
  }, []);

  return <CurrencyContext.Provider value={currency}>{children}</CurrencyContext.Provider>;
}

export function useCurrency() {
  return useContext(CurrencyContext);
}
