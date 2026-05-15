import type { Metadata } from "next";
import "./globals.css";
import TopUtilityBar from "@/components/layout/TopUtilityBar";
import Header from "@/components/layout/Header";
import CategoryNav from "@/components/layout/CategoryNav";
import Footer from "@/components/layout/Footer";
import MobileBottomNav from "@/components/layout/MobileBottomNav";
import { CurrencyProvider } from "@/components/CurrencyProvider";
import { api } from "@/lib/api";

export const metadata: Metadata = {
  title: "Estate Bongo Online — Shop Smarter, Save More",
  description:
    "Estate Bongo Online — the marketplace for everything. Millions of products, daily deals, free shipping."
};

export default async function RootLayout({ children }: { children: React.ReactNode }) {
  const [currency, categories] = await Promise.all([api.currency(), api.categories()]);
  return (
    <html lang="en">
      <body className="min-h-screen bg-surface">
        <CurrencyProvider initialCurrency={currency}>
        <div className="hidden md:block">
          <TopUtilityBar />
        </div>
        <Header />
        <div className="hidden md:block">
          <CategoryNav categories={categories} />
        </div>
        <main className="container-x py-3 pb-24 md:pb-8">{children}</main>
        <Footer />
        <MobileBottomNav />
        </CurrencyProvider>
      </body>
    </html>
  );
}
