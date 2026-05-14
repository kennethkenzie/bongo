import { MessageCircleQuestion } from "lucide-react";

const qas = [
  { q: "Does this ship to Tanzania?", a: "Yes, we ship to Tanzania, Kenya, Uganda and Rwanda. Standard delivery takes 7–14 business days.", asked: "Mar 2026", asker: "Asha M." },
  { q: "Is there a warranty included?", a: "Every order comes with a 12-month manufacturer warranty plus our 30-day return policy.", asked: "Feb 2026", asker: "James K." },
  { q: "Can I get a bulk discount?", a: "Yes — contact the store via chat for orders of 10+ units. Bulk discounts start at 10%.", asked: "Feb 2026", asker: "Pauline N." },
];

export default function QandA() {
  return (
    <section className="card p-4 mt-3">
      <div className="flex items-center justify-between mb-3">
        <h2 className="font-bold flex items-center gap-2">
          <MessageCircleQuestion size={18} className="text-brand-700" /> Questions & Answers
        </h2>
        <button className="btn-outline text-sm py-1.5">Ask a question</button>
      </div>
      <ul className="divide-y divide-line">
        {qas.map((qa, i) => (
          <li key={i} className="py-3">
            <div className="flex items-start gap-2">
              <span className="w-5 h-5 rounded-sm bg-brand-100 text-brand-700 grid place-items-center text-[11px] font-bold mt-0.5">Q</span>
              <div className="flex-1">
                <div className="text-sm font-medium">{qa.q}</div>
                <div className="text-[11px] text-ink-muted">{qa.asker} · {qa.asked}</div>
              </div>
            </div>
            <div className="flex items-start gap-2 mt-2 pl-1">
              <span className="w-5 h-5 rounded-sm bg-emerald-100 text-emerald-700 grid place-items-center text-[11px] font-bold mt-0.5">A</span>
              <div className="text-sm text-ink-soft">{qa.a}</div>
            </div>
          </li>
        ))}
      </ul>
      <button className="btn-outline w-full mt-3 py-2 text-sm">See all questions</button>
    </section>
  );
}
